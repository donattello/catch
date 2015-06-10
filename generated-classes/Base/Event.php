<?php

namespace Base;

use \Comments as ChildComments;
use \CommentsQuery as ChildCommentsQuery;
use \Event as ChildEvent;
use \EventQuery as ChildEventQuery;
use \Sport as ChildSport;
use \SportQuery as ChildSportQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\EventTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'event' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Event implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\EventTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the event_user_id field.
     * @var        int
     */
    protected $event_user_id;

    /**
     * The value for the event_type field.
     * @var        int
     */
    protected $event_type;

    /**
     * The value for the event_date field.
     * @var        \DateTime
     */
    protected $event_date;

    /**
     * The value for the event_place field.
     * @var        string
     */
    protected $event_place;

    /**
     * The value for the event_number_people field.
     * @var        int
     */
    protected $event_number_people;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildSport
     */
    protected $aSport;

    /**
     * @var        ObjectCollection|ChildComments[] Collection to store aggregation of ChildComments objects.
     */
    protected $collCommentss;
    protected $collCommentssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComments[]
     */
    protected $commentssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Event object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Event</code> instance.  If
     * <code>obj</code> is an instance of <code>Event</code>, delegates to
     * <code>equals(Event)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Event The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [event_user_id] column value.
     *
     * @return int
     */
    public function getEventUserId()
    {
        return $this->event_user_id;
    }

    /**
     * Get the [event_type] column value.
     *
     * @return int
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * Get the [optionally formatted] temporal [event_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEventDate($format = NULL)
    {
        if ($format === null) {
            return $this->event_date;
        } else {
            return $this->event_date instanceof \DateTime ? $this->event_date->format($format) : null;
        }
    }

    /**
     * Get the [event_place] column value.
     *
     * @return string
     */
    public function getEventPlace()
    {
        return $this->event_place;
    }

    /**
     * Get the [event_number_people] column value.
     *
     * @return int
     */
    public function getEventNumberPeople()
    {
        return $this->event_number_people;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EventTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [event_user_id] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_user_id !== $v) {
            $this->event_user_id = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setEventUserId()

    /**
     * Set the value of [event_type] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_type !== $v) {
            $this->event_type = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_TYPE] = true;
        }

        if ($this->aSport !== null && $this->aSport->getId() !== $v) {
            $this->aSport = null;
        }

        return $this;
    } // setEventType()

    /**
     * Sets the value of [event_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->event_date !== null || $dt !== null) {
            if ($this->event_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->event_date->format("Y-m-d H:i:s")) {
                $this->event_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_EVENT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEventDate()

    /**
     * Set the value of [event_place] column.
     *
     * @param string $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventPlace($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->event_place !== $v) {
            $this->event_place = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_PLACE] = true;
        }

        return $this;
    } // setEventPlace()

    /**
     * Set the value of [event_number_people] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventNumberPeople($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_number_people !== $v) {
            $this->event_number_people = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_NUMBER_PEOPLE] = true;
        }

        return $this;
    } // setEventNumberPeople()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventTableMap::translateFieldName('EventUserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventTableMap::translateFieldName('EventType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventTableMap::translateFieldName('EventDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->event_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventTableMap::translateFieldName('EventPlace', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_place = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EventTableMap::translateFieldName('EventNumberPeople', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_number_people = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = EventTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Event'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUser !== null && $this->event_user_id !== $this->aUser->getUserId()) {
            $this->aUser = null;
        }
        if ($this->aSport !== null && $this->event_type !== $this->aSport->getId()) {
            $this->aSport = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aSport = null;
            $this->collCommentss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Event::setDeleted()
     * @see Event::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EventTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aSport !== null) {
                if ($this->aSport->isModified() || $this->aSport->isNew()) {
                    $affectedRows += $this->aSport->save($con);
                }
                $this->setSport($this->aSport);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->commentssScheduledForDeletion !== null) {
                if (!$this->commentssScheduledForDeletion->isEmpty()) {
                    foreach ($this->commentssScheduledForDeletion as $comments) {
                        // need to save related object because we set the relation to null
                        $comments->save($con);
                    }
                    $this->commentssScheduledForDeletion = null;
                }
            }

            if ($this->collCommentss !== null) {
                foreach ($this->collCommentss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[EventTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'event_user_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'event_type';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'event_date';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_PLACE)) {
            $modifiedColumns[':p' . $index++]  = 'event_place';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_NUMBER_PEOPLE)) {
            $modifiedColumns[':p' . $index++]  = 'event_number_people';
        }

        $sql = sprintf(
            'INSERT INTO event (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'event_user_id':
                        $stmt->bindValue($identifier, $this->event_user_id, PDO::PARAM_INT);
                        break;
                    case 'event_type':
                        $stmt->bindValue($identifier, $this->event_type, PDO::PARAM_INT);
                        break;
                    case 'event_date':
                        $stmt->bindValue($identifier, $this->event_date ? $this->event_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'event_place':
                        $stmt->bindValue($identifier, $this->event_place, PDO::PARAM_STR);
                        break;
                    case 'event_number_people':
                        $stmt->bindValue($identifier, $this->event_number_people, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getEventUserId();
                break;
            case 2:
                return $this->getEventType();
                break;
            case 3:
                return $this->getEventDate();
                break;
            case 4:
                return $this->getEventPlace();
                break;
            case 5:
                return $this->getEventNumberPeople();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Event'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Event'][$this->hashCode()] = true;
        $keys = EventTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getEventUserId(),
            $keys[2] => $this->getEventType(),
            $keys[3] => $this->getEventDate(),
            $keys[4] => $this->getEventPlace(),
            $keys[5] => $this->getEventNumberPeople(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSport) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sport';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sport';
                        break;
                    default:
                        $key = 'Sport';
                }

                $result[$key] = $this->aSport->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCommentss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commentss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commentss';
                        break;
                    default:
                        $key = 'Commentss';
                }

                $result[$key] = $this->collCommentss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Event
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Event
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setEventUserId($value);
                break;
            case 2:
                $this->setEventType($value);
                break;
            case 3:
                $this->setEventDate($value);
                break;
            case 4:
                $this->setEventPlace($value);
                break;
            case 5:
                $this->setEventNumberPeople($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EventTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventUserId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEventType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEventDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEventPlace($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEventNumberPeople($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Event The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EventTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $criteria->add(EventTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_USER_ID)) {
            $criteria->add(EventTableMap::COL_EVENT_USER_ID, $this->event_user_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TYPE)) {
            $criteria->add(EventTableMap::COL_EVENT_TYPE, $this->event_type);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_DATE)) {
            $criteria->add(EventTableMap::COL_EVENT_DATE, $this->event_date);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_PLACE)) {
            $criteria->add(EventTableMap::COL_EVENT_PLACE, $this->event_place);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_NUMBER_PEOPLE)) {
            $criteria->add(EventTableMap::COL_EVENT_NUMBER_PEOPLE, $this->event_number_people);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEventQuery::create();
        $criteria->add(EventTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Event (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventUserId($this->getEventUserId());
        $copyObj->setEventType($this->getEventType());
        $copyObj->setEventDate($this->getEventDate());
        $copyObj->setEventPlace($this->getEventPlace());
        $copyObj->setEventNumberPeople($this->getEventNumberPeople());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComments($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Event Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setEventUserId(NULL);
        } else {
            $this->setEventUserId($v->getUserId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addEvent($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->event_user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->event_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addEvents($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildSport object.
     *
     * @param  ChildSport $v
     * @return $this|\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSport(ChildSport $v = null)
    {
        if ($v === null) {
            $this->setEventType(NULL);
        } else {
            $this->setEventType($v->getId());
        }

        $this->aSport = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSport object, it will not be re-added.
        if ($v !== null) {
            $v->addEvent($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSport object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSport The associated ChildSport object.
     * @throws PropelException
     */
    public function getSport(ConnectionInterface $con = null)
    {
        if ($this->aSport === null && ($this->event_type !== null)) {
            $this->aSport = ChildSportQuery::create()->findPk($this->event_type, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSport->addEvents($this);
             */
        }

        return $this->aSport;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Comments' == $relationName) {
            return $this->initCommentss();
        }
    }

    /**
     * Clears out the collCommentss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentss()
     */
    public function clearCommentss()
    {
        $this->collCommentss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentss collection loaded partially.
     */
    public function resetPartialCommentss($v = true)
    {
        $this->collCommentssPartial = $v;
    }

    /**
     * Initializes the collCommentss collection.
     *
     * By default this just sets the collCommentss collection to an empty array (like clearcollCommentss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentss($overrideExisting = true)
    {
        if (null !== $this->collCommentss && !$overrideExisting) {
            return;
        }
        $this->collCommentss = new ObjectCollection();
        $this->collCommentss->setModel('\Comments');
    }

    /**
     * Gets an array of ChildComments objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     * @throws PropelException
     */
    public function getCommentss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                // return empty collection
                $this->initCommentss();
            } else {
                $collCommentss = ChildCommentsQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentssPartial && count($collCommentss)) {
                        $this->initCommentss(false);

                        foreach ($collCommentss as $obj) {
                            if (false == $this->collCommentss->contains($obj)) {
                                $this->collCommentss->append($obj);
                            }
                        }

                        $this->collCommentssPartial = true;
                    }

                    return $collCommentss;
                }

                if ($partial && $this->collCommentss) {
                    foreach ($this->collCommentss as $obj) {
                        if ($obj->isNew()) {
                            $collCommentss[] = $obj;
                        }
                    }
                }

                $this->collCommentss = $collCommentss;
                $this->collCommentssPartial = false;
            }
        }

        return $this->collCommentss;
    }

    /**
     * Sets a collection of ChildComments objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setCommentss(Collection $commentss, ConnectionInterface $con = null)
    {
        /** @var ChildComments[] $commentssToDelete */
        $commentssToDelete = $this->getCommentss(new Criteria(), $con)->diff($commentss);


        $this->commentssScheduledForDeletion = $commentssToDelete;

        foreach ($commentssToDelete as $commentsRemoved) {
            $commentsRemoved->setEvent(null);
        }

        $this->collCommentss = null;
        foreach ($commentss as $comments) {
            $this->addComments($comments);
        }

        $this->collCommentss = $commentss;
        $this->collCommentssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comments objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comments objects.
     * @throws PropelException
     */
    public function countCommentss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentss());
            }

            $query = ChildCommentsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collCommentss);
    }

    /**
     * Method called to associate a ChildComments object to this object
     * through the ChildComments foreign key attribute.
     *
     * @param  ChildComments $l ChildComments
     * @return $this|\Event The current object (for fluent API support)
     */
    public function addComments(ChildComments $l)
    {
        if ($this->collCommentss === null) {
            $this->initCommentss();
            $this->collCommentssPartial = true;
        }

        if (!$this->collCommentss->contains($l)) {
            $this->doAddComments($l);
        }

        return $this;
    }

    /**
     * @param ChildComments $comments The ChildComments object to add.
     */
    protected function doAddComments(ChildComments $comments)
    {
        $this->collCommentss[]= $comments;
        $comments->setEvent($this);
    }

    /**
     * @param  ChildComments $comments The ChildComments object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeComments(ChildComments $comments)
    {
        if ($this->getCommentss()->contains($comments)) {
            $pos = $this->collCommentss->search($comments);
            $this->collCommentss->remove($pos);
            if (null === $this->commentssScheduledForDeletion) {
                $this->commentssScheduledForDeletion = clone $this->collCommentss;
                $this->commentssScheduledForDeletion->clear();
            }
            $this->commentssScheduledForDeletion[]= $comments;
            $comments->setEvent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Commentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     */
    public function getCommentssJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getCommentss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeEvent($this);
        }
        if (null !== $this->aSport) {
            $this->aSport->removeEvent($this);
        }
        $this->id = null;
        $this->event_user_id = null;
        $this->event_type = null;
        $this->event_date = null;
        $this->event_place = null;
        $this->event_number_people = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCommentss) {
                foreach ($this->collCommentss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommentss = null;
        $this->aUser = null;
        $this->aSport = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EventTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
