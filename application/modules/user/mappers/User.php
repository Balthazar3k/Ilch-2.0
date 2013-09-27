<?php
/**
 * Holds class User_UserMapper.
 *
 * @author Jainta Martin
 * @copyright Ilch Pluto
 * @package ilch
 */

defined('ACCESS') or die('no direct access');

/**
 * The user model class.
 *
 * @author Jainta Martin
 * @package ilch
 */
class User_UserMapper extends Ilch_Mapper
{
	/**
	 * Returns user model found by the id.
	 *
	 * @param mixed[] $id
	 * @return null|User_UserModel
	 */
	public function getUserById($id)
	{
		$where = array
		(
			'id' => (int)$id,
		);

		$users = $this->_getBy($where);

		if(!empty($users))
		{
			return reset($users);
		}

		return null;
	}

	/**
	 * Returns user model found by the username.
	 *
	 * @param string $name
	 * @return null|User_UserModel
	 */
	public function getUserByName($name)
	{
		$where = array
		(
			'name' => (string)$name,
		);

		$users = $this->_getBy($where);

		if(!empty($users))
		{
			return reset($users);
		}

		return null;
	}

	/**
	 * Returns user model found by the email.
	 *
	 * @param string $email
	 * @return null|User_UserModel
	 */
	public function getUserByEmail($email)
	{
		$where = array
		(
			'email' => (string)$email,
		);

		$users = $this->_getBy($where);

		if(!empty($users))
		{
			return reset($users);
		}

		return null;
	}

	/**
	 * Returns an array with user models found by the where clause of false if
	 * none found.
	 *
	 * @param mixed[] $where
	 * @return null|User_UserModel
	 */
	protected function _getBy($where = null)
	{
		$userRows = $this->getDatabase()->selectArray
		(
			'*',
			'users',
			$where
		);

		if(!empty($userRows))
		{
			$users = array();

			foreach($userRows as $userRow)
			{
				$users[] = $this->loadFromArray($userRow);
			}

			return $users;
		}

		return null;
	}

	/**
	 * Returns a user created using an array with user data.
	 *
	 * @param mixed[] $userRow
	 * @return User_UserModel
	 */
	public function loadFromArray($userRow = array())
	{
		$user = new User_UserModel();

		if(isset($userRow['id']))
		{
			$user->setId($userRow['id']);
		}

		if(isset($userRow['name']))
		{
			$user->setName($userRow['name']);
		}

		if(isset($userRow['email']))
		{
			$user->setEmail($userRow['email']);
		}

		if(isset($userRow['password']))
		{
			$user->setPassword($userRow['password']);
		}

		if(isset($userRow['date_created']))
		{
			$dateCreated = new Ilch_Date($userRow['date_created']);
			$users['date_created'] = $dateCreated;
			$user->setDateCreated($dateCreated);
		}

		if(isset($userRow['date_confirmed']))
		{
			$dateConfirmed = new Ilch_Date($userRow['date_confirmed']);
			$users['date_confirmed'] = $dateConfirmed;
			$user->setDateConfirmed($dateConfirmed);
		}

		return $user;
	}

	/**
	 * Inserts or updates a user model in the database.
	 *
	 * @param User_UserModel $user
	 */
	public function save(User_UserModel $user)
	{
		$fields = array();
		$name = $user->getName();
		$password = $user->getPassword();
		$email = $user->getEmail();
		$dateCreated = $user->getDateCreated();
		$dateConfirmed = $user->getDateConfirmed();

		if(!empty($name))
		{
			$fields['name'] = $user->getName();
		}

		if(!empty($password))
		{
			$fields['password'] = $user->getPassword();
		}

		if(!empty($email))
		{
			$fields['email'] = $user->getEmail();
		}

		if(!empty($dateCreated))
		{
			$fields['date_created'] = $user->getDateCreated()->toDb();
		}

		if(!empty($dateConfirmed))
		{
			$fields['date_confirmed'] = $user->getDateConfirmed()->toDb();
		}

		$userId = $user->getId();

		if($userId && $this->getUserById($userId))
		{
			/*
			 * User does exist already, update.
			 */
			$this->getDatabase()->update
			(
				$fields,
				'users',
				array
				(
					'id' => $userId,
				)
			);
		}
		else
		{
			/*
			 * User does not exist yet, insert.
			 */
			$userId = $this->getDatabase()->insert
			(
				$fields,
				'users'
			);
		}

		if($user->getGroups())
		{
			$this->getDatabase()->delete
			(
				'users_groups',
				array('user_id' => $userId)
			);

			foreach($user->getGroups() as $groupId)
			{
				$this->getDatabase()->insert
				(
					array
					(
						'user_id' => $userId,
						'group_id' => $groupId
					),
					'users_groups'
				);
			}
		}
	}
}