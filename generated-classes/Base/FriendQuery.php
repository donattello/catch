<?php

namespace Base;

use \Friend as ChildFriend;
use \FriendQuery as ChildFriendQuery;
use \Exception;
use \PDO;
use Map\FriendTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'friend' table.
 *
 *
 *
 * @method     ChildFriendQuery orderByFriendTId($order = Criteria::ASC) Order by the friend_t_id column
 * @method     ChildFriendQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildFriendQuery orderByFriendId($order = Criteria::ASC) Order by the friend_id column
 *
 * @method     ChildFriendQuery groupByFriendTId() Group by the friend_t_id column
 * @method     ChildFriendQuery groupByUserId() Group by the user_id column
 * @method     ChildFriendQuery groupByFriendId() Group by the friend_id column
 *
 * @method     ChildFriendQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFriendQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFriendQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFriendQuery leftJoinUserRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUserId relation
 * @method     ChildFriendQuery rightJoinUserRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUserId relation
 * @method     ChildFriendQuery innerJoinUserRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUserId relation
 *
 * @method     ChildFriendQuery leftJoinUserRelatedByFriendId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByFriendId relation
 * @method     ChildFriendQuery rightJoinUserRelatedByFriendId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByFriendId relation
 * @method     ChildFriendQuery innerJoinUserRelatedByFriendId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByFriendId relation
 *
 * @method     \UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFriend findOne(ConnectionInterface $con = null) Return the first ChildFriend matching the query
 * @method     ChildFriend findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFriend matching the query, or a new ChildFriend object populated from the query conditions when no match is found
 *
 * @method     ChildFriend findOneByFriendTId(int $friend_t_id) Return the first ChildFriend filtered by the friend_t_id column
 * @method     ChildFriend findOneByUserId(int $user_id) Return the first ChildFriend filtered by the user_id column
 * @method     ChildFriend findOneByFriendId(int $friend_id) Return the first ChildFriend filtered by the friend_id column *

 * @method     ChildFriend requirePk($key, ConnectionInterface $con = null) Return the ChildFriend by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFriend requireOne(ConnectionInterface $con = null) Return the first ChildFriend matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFriend requireOneByFriendTId(int $friend_t_id) Return the first ChildFriend filtered by the friend_t_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFriend requireOneByUserId(int $user_id) Return the first ChildFriend filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFriend requireOneByFriendId(int $friend_id) Return the first ChildFriend filtered by the friend_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFriend[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFriend objects based on current ModelCriteria
 * @method     ChildFriend[]|ObjectCollection findByFriendTId(int $friend_t_id) Return ChildFriend objects filtered by the friend_t_id column
 * @method     ChildFriend[]|ObjectCollection findByUserId(int $user_id) Return ChildFriend objects filtered by the user_id column
 * @method     ChildFriend[]|ObjectCollection findByFriendId(int $friend_id) Return ChildFriend objects filtered by the friend_id column
 * @method     ChildFriend[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FriendQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FriendQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Friend', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFriendQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFriendQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFriendQuery) {
            return $criteria;
        }
        $query = new ChildFriendQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildFriend|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FriendTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FriendTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFriend A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT friend_t_id, user_id, friend_id FROM friend WHERE friend_t_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildFriend $obj */
            $obj = new ChildFriend();
            $obj->hydrate($row);
            FriendTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildFriend|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the friend_t_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFriendTId(1234); // WHERE friend_t_id = 1234
     * $query->filterByFriendTId(array(12, 34)); // WHERE friend_t_id IN (12, 34)
     * $query->filterByFriendTId(array('min' => 12)); // WHERE friend_t_id > 12
     * </code>
     *
     * @param     mixed $friendTId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function filterByFriendTId($friendTId = null, $comparison = null)
    {
        if (is_array($friendTId)) {
            $useMinMax = false;
            if (isset($friendTId['min'])) {
                $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $friendTId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($friendTId['max'])) {
                $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $friendTId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $friendTId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUserRelatedByUserId()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(FriendTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(FriendTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the friend_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFriendId(1234); // WHERE friend_id = 1234
     * $query->filterByFriendId(array(12, 34)); // WHERE friend_id IN (12, 34)
     * $query->filterByFriendId(array('min' => 12)); // WHERE friend_id > 12
     * </code>
     *
     * @see       filterByUserRelatedByFriendId()
     *
     * @param     mixed $friendId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function filterByFriendId($friendId = null, $comparison = null)
    {
        if (is_array($friendId)) {
            $useMinMax = false;
            if (isset($friendId['min'])) {
                $this->addUsingAlias(FriendTableMap::COL_FRIEND_ID, $friendId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($friendId['max'])) {
                $this->addUsingAlias(FriendTableMap::COL_FRIEND_ID, $friendId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendTableMap::COL_FRIEND_ID, $friendId, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFriendQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUserId($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(FriendTableMap::COL_USER_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FriendTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByUserId() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function joinUserRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByUserId relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUserId', '\UserQuery');
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFriendQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByFriendId($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(FriendTableMap::COL_FRIEND_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FriendTableMap::COL_FRIEND_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByFriendId() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByFriendId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function joinUserRelatedByFriendId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByFriendId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByFriendId');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByFriendId relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByFriendIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByFriendId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByFriendId', '\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFriend $friend Object to remove from the list of results
     *
     * @return $this|ChildFriendQuery The current query, for fluid interface
     */
    public function prune($friend = null)
    {
        if ($friend) {
            $this->addUsingAlias(FriendTableMap::COL_FRIEND_T_ID, $friend->getFriendTId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the friend table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FriendTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FriendTableMap::clearInstancePool();
            FriendTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FriendTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FriendTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FriendTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FriendTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FriendQuery
