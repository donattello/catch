<?php

namespace Base;

use \Comments as ChildComments;
use \CommentsQuery as ChildCommentsQuery;
use \Event as ChildEvent;
use \EventQuery as ChildEventQuery;
use \Friend as ChildFriend;
use \FriendQuery as ChildFriendQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Exception;
use \PDO;
use Map\UserTableMap;
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

/**
 * Base class that represents a row from the 'user' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


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
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the user_name field.
     * @var        string
     */
    protected $user_name;

    /**
     * The value for the user_password_hash field.
     * @var        string
     */
    protected $user_password_hash;

    /**
     * The value for the user_email field.
     * @var        string
     */
    protected $user_email;

    /**
     * The value for the bio field.
     * @var        string
     */
    protected $bio;

    /**
     * The value for the user_age field.
     * @var        int
     */
    protected $user_age;

    /**
     * The value for the user_gender field.
     * @var        string
     */
    protected $user_gender;

    /**
     * @var        ObjectCollection|ChildComments[] Collection to store aggregation of ChildComments objects.
     */
    protected $collCommentss;
    protected $collCommentssPartial;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEvents;
    protected $collEventsPartial;

    /**
     * @var        ObjectCollection|ChildFriend[] Collection to store aggregation of ChildFriend objects.
     */
    protected $collFriendsRelatedByUserId;
    protected $collFriendsRelatedByUserIdPartial;

    /**
     * @var        ObjectCollection|ChildFriend[] Collection to store aggregation of ChildFriend objects.
     */
    protected $collFriendsRelatedByFriendId;
    protected $collFriendsRelatedByFriendIdPartial;

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
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFriend[]
     */
    protected $friendsRelatedByUserIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFriend[]
     */
    protected $friendsRelatedByFriendIdScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [user_name] column value.
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Get the [user_password_hash] column value.
     *
     * @return string
     */
    public function getUserPasswordHash()
    {
        return $this->user_password_hash;
    }

    /**
     * Get the [user_email] column value.
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Get the [bio] column value.
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Get the [user_age] column value.
     *
     * @return int
     */
    public function getUserAge()
    {
        return $this->user_age;
    }

    /**
     * Get the [user_gender] column value.
     *
     * @return string
     */
    public function getUserGender()
    {
        return $this->user_gender;
    }

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [user_name] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_name !== $v) {
            $this->user_name = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_NAME] = true;
        }

        return $this;
    } // setUserName()

    /**
     * Set the value of [user_password_hash] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserPasswordHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_password_hash !== $v) {
            $this->user_password_hash = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_PASSWORD_HASH] = true;
        }

        return $this;
    } // setUserPasswordHash()

    /**
     * Set the value of [user_email] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_email !== $v) {
            $this->user_email = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_EMAIL] = true;
        }

        return $this;
    } // setUserEmail()

    /**
     * Set the value of [bio] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setBio($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->bio !== $v) {
            $this->bio = $v;
            $this->modifiedColumns[UserTableMap::COL_BIO] = true;
        }

        return $this;
    } // setBio()

    /**
     * Set the value of [user_age] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserAge($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_age !== $v) {
            $this->user_age = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_AGE] = true;
        }

        return $this;
    } // setUserAge()

    /**
     * Set the value of [user_gender] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUserGender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_gender !== $v) {
            $this->user_gender = $v;
            $this->modifiedColumns[UserTableMap::COL_USER_GENDER] = true;
        }

        return $this;
    } // setUserGender()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('UserName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('UserPasswordHash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_password_hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('UserEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Bio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bio = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('UserAge', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_age = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('UserGender', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_gender = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCommentss = null;

            $this->collEvents = null;

            $this->collFriendsRelatedByUserId = null;

            $this->collFriendsRelatedByFriendId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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

            if ($this->eventsScheduledForDeletion !== null) {
                if (!$this->eventsScheduledForDeletion->isEmpty()) {
                    \EventQuery::create()
                        ->filterByPrimaryKeys($this->eventsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->eventsScheduledForDeletion = null;
                }
            }

            if ($this->collEvents !== null) {
                foreach ($this->collEvents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->friendsRelatedByUserIdScheduledForDeletion !== null) {
                if (!$this->friendsRelatedByUserIdScheduledForDeletion->isEmpty()) {
                    \FriendQuery::create()
                        ->filterByPrimaryKeys($this->friendsRelatedByUserIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->friendsRelatedByUserIdScheduledForDeletion = null;
                }
            }

            if ($this->collFriendsRelatedByUserId !== null) {
                foreach ($this->collFriendsRelatedByUserId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->friendsRelatedByFriendIdScheduledForDeletion !== null) {
                if (!$this->friendsRelatedByFriendIdScheduledForDeletion->isEmpty()) {
                    \FriendQuery::create()
                        ->filterByPrimaryKeys($this->friendsRelatedByFriendIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->friendsRelatedByFriendIdScheduledForDeletion = null;
                }
            }

            if ($this->collFriendsRelatedByFriendId !== null) {
                foreach ($this->collFriendsRelatedByFriendId as $referrerFK) {
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

        $this->modifiedColumns[UserTableMap::COL_USER_ID] = true;
        if (null !== $this->user_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_USER_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'user_name';
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_PASSWORD_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'user_password_hash';
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'user_email';
        }
        if ($this->isColumnModified(UserTableMap::COL_BIO)) {
            $modifiedColumns[':p' . $index++]  = 'bio';
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_AGE)) {
            $modifiedColumns[':p' . $index++]  = 'user_age';
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_GENDER)) {
            $modifiedColumns[':p' . $index++]  = 'user_gender';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'user_name':
                        $stmt->bindValue($identifier, $this->user_name, PDO::PARAM_STR);
                        break;
                    case 'user_password_hash':
                        $stmt->bindValue($identifier, $this->user_password_hash, PDO::PARAM_STR);
                        break;
                    case 'user_email':
                        $stmt->bindValue($identifier, $this->user_email, PDO::PARAM_STR);
                        break;
                    case 'bio':
                        $stmt->bindValue($identifier, $this->bio, PDO::PARAM_STR);
                        break;
                    case 'user_age':
                        $stmt->bindValue($identifier, $this->user_age, PDO::PARAM_INT);
                        break;
                    case 'user_gender':
                        $stmt->bindValue($identifier, $this->user_gender, PDO::PARAM_STR);
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
        $this->setUserId($pk);

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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUserId();
                break;
            case 1:
                return $this->getUserName();
                break;
            case 2:
                return $this->getUserPasswordHash();
                break;
            case 3:
                return $this->getUserEmail();
                break;
            case 4:
                return $this->getBio();
                break;
            case 5:
                return $this->getUserAge();
                break;
            case 6:
                return $this->getUserGender();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getUserId(),
            $keys[1] => $this->getUserName(),
            $keys[2] => $this->getUserPasswordHash(),
            $keys[3] => $this->getUserEmail(),
            $keys[4] => $this->getBio(),
            $keys[5] => $this->getUserAge(),
            $keys[6] => $this->getUserGender(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collEvents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEvents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFriendsRelatedByUserId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'friends';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'friends';
                        break;
                    default:
                        $key = 'Friends';
                }

                $result[$key] = $this->collFriendsRelatedByUserId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFriendsRelatedByFriendId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'friends';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'friends';
                        break;
                    default:
                        $key = 'Friends';
                }

                $result[$key] = $this->collFriendsRelatedByFriendId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setUserId($value);
                break;
            case 1:
                $this->setUserName($value);
                break;
            case 2:
                $this->setUserPasswordHash($value);
                break;
            case 3:
                $this->setUserEmail($value);
                break;
            case 4:
                $this->setBio($value);
                break;
            case 5:
                $this->setUserAge($value);
                break;
            case 6:
                $this->setUserGender($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setUserId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserPasswordHash($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUserEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBio($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUserAge($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUserGender($arr[$keys[6]]);
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
     * @return $this|\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_USER_ID)) {
            $criteria->add(UserTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_NAME)) {
            $criteria->add(UserTableMap::COL_USER_NAME, $this->user_name);
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_PASSWORD_HASH)) {
            $criteria->add(UserTableMap::COL_USER_PASSWORD_HASH, $this->user_password_hash);
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_EMAIL)) {
            $criteria->add(UserTableMap::COL_USER_EMAIL, $this->user_email);
        }
        if ($this->isColumnModified(UserTableMap::COL_BIO)) {
            $criteria->add(UserTableMap::COL_BIO, $this->bio);
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_AGE)) {
            $criteria->add(UserTableMap::COL_USER_AGE, $this->user_age);
        }
        if ($this->isColumnModified(UserTableMap::COL_USER_GENDER)) {
            $criteria->add(UserTableMap::COL_USER_GENDER, $this->user_gender);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_USER_ID, $this->user_id);

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
        $validPk = null !== $this->getUserId();

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
        return $this->getUserId();
    }

    /**
     * Generic method to set the primary key (user_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setUserId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getUserId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserName($this->getUserName());
        $copyObj->setUserPasswordHash($this->getUserPasswordHash());
        $copyObj->setUserEmail($this->getUserEmail());
        $copyObj->setBio($this->getBio());
        $copyObj->setUserAge($this->getUserAge());
        $copyObj->setUserGender($this->getUserGender());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComments($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEvents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEvent($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFriendsRelatedByUserId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFriendRelatedByUserId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFriendsRelatedByFriendId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFriendRelatedByFriendId($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setUserId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \User Clone of current object.
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
        if ('Event' == $relationName) {
            return $this->initEvents();
        }
        if ('FriendRelatedByUserId' == $relationName) {
            return $this->initFriendsRelatedByUserId();
        }
        if ('FriendRelatedByFriendId' == $relationName) {
            return $this->initFriendsRelatedByFriendId();
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCommentss(Collection $commentss, ConnectionInterface $con = null)
    {
        /** @var ChildComments[] $commentssToDelete */
        $commentssToDelete = $this->getCommentss(new Criteria(), $con)->diff($commentss);


        $this->commentssScheduledForDeletion = $commentssToDelete;

        foreach ($commentssToDelete as $commentsRemoved) {
            $commentsRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collCommentss);
    }

    /**
     * Method called to associate a ChildComments object to this object
     * through the ChildComments foreign key attribute.
     *
     * @param  ChildComments $l ChildComments
     * @return $this|\User The current object (for fluent API support)
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
        $comments->setUser($this);
    }

    /**
     * @param  ChildComments $comments The ChildComments object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $comments->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Commentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     */
    public function getCommentssJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getCommentss($query, $con);
    }

    /**
     * Clears out the collEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEvents()
     */
    public function clearEvents()
    {
        $this->collEvents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEvents collection loaded partially.
     */
    public function resetPartialEvents($v = true)
    {
        $this->collEventsPartial = $v;
    }

    /**
     * Initializes the collEvents collection.
     *
     * By default this just sets the collEvents collection to an empty array (like clearcollEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEvents($overrideExisting = true)
    {
        if (null !== $this->collEvents && !$overrideExisting) {
            return;
        }
        $this->collEvents = new ObjectCollection();
        $this->collEvents->setModel('\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEvents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if (null === $this->collEvents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEvents) {
                // return empty collection
                $this->initEvents();
            } else {
                $collEvents = ChildEventQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsPartial && count($collEvents)) {
                        $this->initEvents(false);

                        foreach ($collEvents as $obj) {
                            if (false == $this->collEvents->contains($obj)) {
                                $this->collEvents->append($obj);
                            }
                        }

                        $this->collEventsPartial = true;
                    }

                    return $collEvents;
                }

                if ($partial && $this->collEvents) {
                    foreach ($this->collEvents as $obj) {
                        if ($obj->isNew()) {
                            $collEvents[] = $obj;
                        }
                    }
                }

                $this->collEvents = $collEvents;
                $this->collEventsPartial = false;
            }
        }

        return $this->collEvents;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $events A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setEvents(Collection $events, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsToDelete */
        $eventsToDelete = $this->getEvents(new Criteria(), $con)->diff($events);


        $this->eventsScheduledForDeletion = $eventsToDelete;

        foreach ($eventsToDelete as $eventRemoved) {
            $eventRemoved->setUser(null);
        }

        $this->collEvents = null;
        foreach ($events as $event) {
            $this->addEvent($event);
        }

        $this->collEvents = $events;
        $this->collEventsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEvents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if (null === $this->collEvents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEvents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEvents());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collEvents);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\User The current object (for fluent API support)
     */
    public function addEvent(ChildEvent $l)
    {
        if ($this->collEvents === null) {
            $this->initEvents();
            $this->collEventsPartial = true;
        }

        if (!$this->collEvents->contains($l)) {
            $this->doAddEvent($l);
        }

        return $this;
    }

    /**
     * @param ChildEvent $event The ChildEvent object to add.
     */
    protected function doAddEvent(ChildEvent $event)
    {
        $this->collEvents[]= $event;
        $event->setUser($this);
    }

    /**
     * @param  ChildEvent $event The ChildEvent object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeEvent(ChildEvent $event)
    {
        if ($this->getEvents()->contains($event)) {
            $pos = $this->collEvents->search($event);
            $this->collEvents->remove($pos);
            if (null === $this->eventsScheduledForDeletion) {
                $this->eventsScheduledForDeletion = clone $this->collEvents;
                $this->eventsScheduledForDeletion->clear();
            }
            $this->eventsScheduledForDeletion[]= clone $event;
            $event->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Events from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     */
    public function getEventsJoinSport(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('Sport', $joinBehavior);

        return $this->getEvents($query, $con);
    }

    /**
     * Clears out the collFriendsRelatedByUserId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFriendsRelatedByUserId()
     */
    public function clearFriendsRelatedByUserId()
    {
        $this->collFriendsRelatedByUserId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFriendsRelatedByUserId collection loaded partially.
     */
    public function resetPartialFriendsRelatedByUserId($v = true)
    {
        $this->collFriendsRelatedByUserIdPartial = $v;
    }

    /**
     * Initializes the collFriendsRelatedByUserId collection.
     *
     * By default this just sets the collFriendsRelatedByUserId collection to an empty array (like clearcollFriendsRelatedByUserId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFriendsRelatedByUserId($overrideExisting = true)
    {
        if (null !== $this->collFriendsRelatedByUserId && !$overrideExisting) {
            return;
        }
        $this->collFriendsRelatedByUserId = new ObjectCollection();
        $this->collFriendsRelatedByUserId->setModel('\Friend');
    }

    /**
     * Gets an array of ChildFriend objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFriend[] List of ChildFriend objects
     * @throws PropelException
     */
    public function getFriendsRelatedByUserId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFriendsRelatedByUserIdPartial && !$this->isNew();
        if (null === $this->collFriendsRelatedByUserId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFriendsRelatedByUserId) {
                // return empty collection
                $this->initFriendsRelatedByUserId();
            } else {
                $collFriendsRelatedByUserId = ChildFriendQuery::create(null, $criteria)
                    ->filterByUserRelatedByUserId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFriendsRelatedByUserIdPartial && count($collFriendsRelatedByUserId)) {
                        $this->initFriendsRelatedByUserId(false);

                        foreach ($collFriendsRelatedByUserId as $obj) {
                            if (false == $this->collFriendsRelatedByUserId->contains($obj)) {
                                $this->collFriendsRelatedByUserId->append($obj);
                            }
                        }

                        $this->collFriendsRelatedByUserIdPartial = true;
                    }

                    return $collFriendsRelatedByUserId;
                }

                if ($partial && $this->collFriendsRelatedByUserId) {
                    foreach ($this->collFriendsRelatedByUserId as $obj) {
                        if ($obj->isNew()) {
                            $collFriendsRelatedByUserId[] = $obj;
                        }
                    }
                }

                $this->collFriendsRelatedByUserId = $collFriendsRelatedByUserId;
                $this->collFriendsRelatedByUserIdPartial = false;
            }
        }

        return $this->collFriendsRelatedByUserId;
    }

    /**
     * Sets a collection of ChildFriend objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $friendsRelatedByUserId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setFriendsRelatedByUserId(Collection $friendsRelatedByUserId, ConnectionInterface $con = null)
    {
        /** @var ChildFriend[] $friendsRelatedByUserIdToDelete */
        $friendsRelatedByUserIdToDelete = $this->getFriendsRelatedByUserId(new Criteria(), $con)->diff($friendsRelatedByUserId);


        $this->friendsRelatedByUserIdScheduledForDeletion = $friendsRelatedByUserIdToDelete;

        foreach ($friendsRelatedByUserIdToDelete as $friendRelatedByUserIdRemoved) {
            $friendRelatedByUserIdRemoved->setUserRelatedByUserId(null);
        }

        $this->collFriendsRelatedByUserId = null;
        foreach ($friendsRelatedByUserId as $friendRelatedByUserId) {
            $this->addFriendRelatedByUserId($friendRelatedByUserId);
        }

        $this->collFriendsRelatedByUserId = $friendsRelatedByUserId;
        $this->collFriendsRelatedByUserIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Friend objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Friend objects.
     * @throws PropelException
     */
    public function countFriendsRelatedByUserId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFriendsRelatedByUserIdPartial && !$this->isNew();
        if (null === $this->collFriendsRelatedByUserId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFriendsRelatedByUserId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFriendsRelatedByUserId());
            }

            $query = ChildFriendQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUserId($this)
                ->count($con);
        }

        return count($this->collFriendsRelatedByUserId);
    }

    /**
     * Method called to associate a ChildFriend object to this object
     * through the ChildFriend foreign key attribute.
     *
     * @param  ChildFriend $l ChildFriend
     * @return $this|\User The current object (for fluent API support)
     */
    public function addFriendRelatedByUserId(ChildFriend $l)
    {
        if ($this->collFriendsRelatedByUserId === null) {
            $this->initFriendsRelatedByUserId();
            $this->collFriendsRelatedByUserIdPartial = true;
        }

        if (!$this->collFriendsRelatedByUserId->contains($l)) {
            $this->doAddFriendRelatedByUserId($l);
        }

        return $this;
    }

    /**
     * @param ChildFriend $friendRelatedByUserId The ChildFriend object to add.
     */
    protected function doAddFriendRelatedByUserId(ChildFriend $friendRelatedByUserId)
    {
        $this->collFriendsRelatedByUserId[]= $friendRelatedByUserId;
        $friendRelatedByUserId->setUserRelatedByUserId($this);
    }

    /**
     * @param  ChildFriend $friendRelatedByUserId The ChildFriend object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeFriendRelatedByUserId(ChildFriend $friendRelatedByUserId)
    {
        if ($this->getFriendsRelatedByUserId()->contains($friendRelatedByUserId)) {
            $pos = $this->collFriendsRelatedByUserId->search($friendRelatedByUserId);
            $this->collFriendsRelatedByUserId->remove($pos);
            if (null === $this->friendsRelatedByUserIdScheduledForDeletion) {
                $this->friendsRelatedByUserIdScheduledForDeletion = clone $this->collFriendsRelatedByUserId;
                $this->friendsRelatedByUserIdScheduledForDeletion->clear();
            }
            $this->friendsRelatedByUserIdScheduledForDeletion[]= clone $friendRelatedByUserId;
            $friendRelatedByUserId->setUserRelatedByUserId(null);
        }

        return $this;
    }

    /**
     * Clears out the collFriendsRelatedByFriendId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFriendsRelatedByFriendId()
     */
    public function clearFriendsRelatedByFriendId()
    {
        $this->collFriendsRelatedByFriendId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFriendsRelatedByFriendId collection loaded partially.
     */
    public function resetPartialFriendsRelatedByFriendId($v = true)
    {
        $this->collFriendsRelatedByFriendIdPartial = $v;
    }

    /**
     * Initializes the collFriendsRelatedByFriendId collection.
     *
     * By default this just sets the collFriendsRelatedByFriendId collection to an empty array (like clearcollFriendsRelatedByFriendId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFriendsRelatedByFriendId($overrideExisting = true)
    {
        if (null !== $this->collFriendsRelatedByFriendId && !$overrideExisting) {
            return;
        }
        $this->collFriendsRelatedByFriendId = new ObjectCollection();
        $this->collFriendsRelatedByFriendId->setModel('\Friend');
    }

    /**
     * Gets an array of ChildFriend objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFriend[] List of ChildFriend objects
     * @throws PropelException
     */
    public function getFriendsRelatedByFriendId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFriendsRelatedByFriendIdPartial && !$this->isNew();
        if (null === $this->collFriendsRelatedByFriendId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFriendsRelatedByFriendId) {
                // return empty collection
                $this->initFriendsRelatedByFriendId();
            } else {
                $collFriendsRelatedByFriendId = ChildFriendQuery::create(null, $criteria)
                    ->filterByUserRelatedByFriendId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFriendsRelatedByFriendIdPartial && count($collFriendsRelatedByFriendId)) {
                        $this->initFriendsRelatedByFriendId(false);

                        foreach ($collFriendsRelatedByFriendId as $obj) {
                            if (false == $this->collFriendsRelatedByFriendId->contains($obj)) {
                                $this->collFriendsRelatedByFriendId->append($obj);
                            }
                        }

                        $this->collFriendsRelatedByFriendIdPartial = true;
                    }

                    return $collFriendsRelatedByFriendId;
                }

                if ($partial && $this->collFriendsRelatedByFriendId) {
                    foreach ($this->collFriendsRelatedByFriendId as $obj) {
                        if ($obj->isNew()) {
                            $collFriendsRelatedByFriendId[] = $obj;
                        }
                    }
                }

                $this->collFriendsRelatedByFriendId = $collFriendsRelatedByFriendId;
                $this->collFriendsRelatedByFriendIdPartial = false;
            }
        }

        return $this->collFriendsRelatedByFriendId;
    }

    /**
     * Sets a collection of ChildFriend objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $friendsRelatedByFriendId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setFriendsRelatedByFriendId(Collection $friendsRelatedByFriendId, ConnectionInterface $con = null)
    {
        /** @var ChildFriend[] $friendsRelatedByFriendIdToDelete */
        $friendsRelatedByFriendIdToDelete = $this->getFriendsRelatedByFriendId(new Criteria(), $con)->diff($friendsRelatedByFriendId);


        $this->friendsRelatedByFriendIdScheduledForDeletion = $friendsRelatedByFriendIdToDelete;

        foreach ($friendsRelatedByFriendIdToDelete as $friendRelatedByFriendIdRemoved) {
            $friendRelatedByFriendIdRemoved->setUserRelatedByFriendId(null);
        }

        $this->collFriendsRelatedByFriendId = null;
        foreach ($friendsRelatedByFriendId as $friendRelatedByFriendId) {
            $this->addFriendRelatedByFriendId($friendRelatedByFriendId);
        }

        $this->collFriendsRelatedByFriendId = $friendsRelatedByFriendId;
        $this->collFriendsRelatedByFriendIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Friend objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Friend objects.
     * @throws PropelException
     */
    public function countFriendsRelatedByFriendId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFriendsRelatedByFriendIdPartial && !$this->isNew();
        if (null === $this->collFriendsRelatedByFriendId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFriendsRelatedByFriendId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFriendsRelatedByFriendId());
            }

            $query = ChildFriendQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByFriendId($this)
                ->count($con);
        }

        return count($this->collFriendsRelatedByFriendId);
    }

    /**
     * Method called to associate a ChildFriend object to this object
     * through the ChildFriend foreign key attribute.
     *
     * @param  ChildFriend $l ChildFriend
     * @return $this|\User The current object (for fluent API support)
     */
    public function addFriendRelatedByFriendId(ChildFriend $l)
    {
        if ($this->collFriendsRelatedByFriendId === null) {
            $this->initFriendsRelatedByFriendId();
            $this->collFriendsRelatedByFriendIdPartial = true;
        }

        if (!$this->collFriendsRelatedByFriendId->contains($l)) {
            $this->doAddFriendRelatedByFriendId($l);
        }

        return $this;
    }

    /**
     * @param ChildFriend $friendRelatedByFriendId The ChildFriend object to add.
     */
    protected function doAddFriendRelatedByFriendId(ChildFriend $friendRelatedByFriendId)
    {
        $this->collFriendsRelatedByFriendId[]= $friendRelatedByFriendId;
        $friendRelatedByFriendId->setUserRelatedByFriendId($this);
    }

    /**
     * @param  ChildFriend $friendRelatedByFriendId The ChildFriend object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeFriendRelatedByFriendId(ChildFriend $friendRelatedByFriendId)
    {
        if ($this->getFriendsRelatedByFriendId()->contains($friendRelatedByFriendId)) {
            $pos = $this->collFriendsRelatedByFriendId->search($friendRelatedByFriendId);
            $this->collFriendsRelatedByFriendId->remove($pos);
            if (null === $this->friendsRelatedByFriendIdScheduledForDeletion) {
                $this->friendsRelatedByFriendIdScheduledForDeletion = clone $this->collFriendsRelatedByFriendId;
                $this->friendsRelatedByFriendIdScheduledForDeletion->clear();
            }
            $this->friendsRelatedByFriendIdScheduledForDeletion[]= clone $friendRelatedByFriendId;
            $friendRelatedByFriendId->setUserRelatedByFriendId(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->user_id = null;
        $this->user_name = null;
        $this->user_password_hash = null;
        $this->user_email = null;
        $this->bio = null;
        $this->user_age = null;
        $this->user_gender = null;
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
            if ($this->collEvents) {
                foreach ($this->collEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFriendsRelatedByUserId) {
                foreach ($this->collFriendsRelatedByUserId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFriendsRelatedByFriendId) {
                foreach ($this->collFriendsRelatedByFriendId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommentss = null;
        $this->collEvents = null;
        $this->collFriendsRelatedByUserId = null;
        $this->collFriendsRelatedByFriendId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
