
<?php

Class ParentDB {

    public static function getParentByEmail($email) {
        $db = Database::getDB();
        $query = 'SELECT * FROM parent  '
                . 'WHERE email =  :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $parent = new ParentClass($row['id'], $row['roleId'], $row['firstName'], $row['lastName'], $row['phone'], $row['email'], $row['password'], $row["zip"], $row['active']);
        return $parent;
    }

    public static function addParent($parent) {
        $db = Database::getDB();
        $query = 'INSERT INTO parent
                 (firstName, roleId, lastName, phone, email, password, zip)
              VALUES
                 (:firstName, :roleId, :lastName, :phone, :email, :password, :zip)';
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $parent->getFirstName());
        $statement->bindValue(':roleId', $parent->getRoleId());
        $statement->bindValue(':lastName', $parent->getLastName());
        $statement->bindValue(':phone', $parent->getPhone());
        $statement->bindValue(':email', $parent->getEmail());
        $statement->bindValue(':password', $parent->getPassword());
        $statement->bindValue(':zip', $parent->getZip());
        $statement->execute();
        $parentId = $db->lastInsertId();
        $statement->closeCursor();

        return $parentId;
    }

    public static function addChildToParent($child) {
        $db = Database::getDB();
        $query = 'INSERT INTO child
                 (parentId, username, birthday)
              VALUES
                 (:parentId, :username, :birthday)';
        $statement = $db->prepare($query);
        $statement->bindValue(':parentId', $child->getParentId());
        $statement->bindValue(':username', $child->getChildUsername());
        $statement->bindValue(':birthday', $child->getBirthday());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getParentById($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM parent 
              WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row['id'] > 0) {
            $parent = new ParentClass($row['id'], $row['roleId'], $row['firstName'], $row['lastName'], $row['phone'], $row['email'], $row['password'], $row["zip"], $row['active']);
        } else {
            $parent = new ParentClass(-1, 1, "", "", "", "", "", "", 1);
        }

        return $parent;
    }

    public static function getAllChildrenByParentId($parentId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM child
                WHERE parentId = :parentId';
        $statement = $db->prepare($query);
        $statement->bindValue(':parentId', $parentId);
        $statement->execute();
        $children = array();
        foreach ($statement as $row) {
            $child = new ChildClass($row['id'], $row['parentId'], $row['userName'], $row['birthday'], $row['active']);
            $children[] = $child;
        }
        return $children;
    }

    public static function getAllActiveChildrenByParentId($parentId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM child
                WHERE parentId = :parentId
                AND active = 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':parentId', $parentId);
        $statement->execute();
        $children = array();
        foreach ($statement as $row) {
            if ($row['id'] > 0) {
                $child = new ChildClass($row['id'], $row['parentId'], $row['userName'], $row['birthday'], $row['active']);
                $children[] = $child;
            } else {
                $children[] = null;
            }
        }
        return $children;
    }

    public static function updateParent($parent) {
        $db = Database::getDB();
        $query = 'UPDATE parent
                SET roleId = :roleId,
                    firstName = :firstName,
                    lastName = :lastName,
                    phone = :phone,
                    email = :email,
                    password = :password,
                    zip = :zip,
                    active = :active,
                    dateMod = now()
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $parent->getId());
        $statement->bindValue(':roleId', $parent->getRoleId());
        $statement->bindValue(':firstName', $parent->getFirstName());
        $statement->bindValue(':lastName', $parent->getLastName());
        $statement->bindValue(':phone', $parent->getPhone());
        $statement->bindValue(':email', $parent->getEmail());
        $statement->bindValue(':password', $parent->getPassword());
        $statement->bindValue(':zip', $parent->getZip());
        $statement->bindValue(':active', $parent->getIsActive());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getChildById($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM child 
              WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row['id'] > 0) {
            $child = new ChildClass($row['id'], $row['parentId'], $row['userName'], $row['birthday'], $row['active']);
        } else {
            $child = new ChildClass(-1, "", "", "", 1);
        }

        return $child;
    }

    public static function updateChild($child) {
        $db = Database::getDB();
        $query = 'UPDATE child
                SET 
                    parentId = :parentId,
                    userName = :userName,
                    birthday = :birthday,
                    active = :active,
                    dateMod = now()
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $child->getId());
        $statement->bindValue(':parentId', $child->getParentId());
        $statement->bindValue(':userName', $child->getChildUsername());
        $statement->bindValue(':birthday', $child->getBirthday());
        $statement->bindValue(':active', $child->getIsActive());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteParentById($parentId) {
        $db = Database::getDB();
        $query = 'UPDATE parent
                SET active = :active,
                dateMod = now()
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $parentId);
        $statement->bindValue(':active', 2);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteChildByParentId($parentId) {
        $db = Database::getDB();
        $query = 'UPDATE child
                SET active = :active,
                dateMod = now()
                WHERE parentId = :parentId';

        $statement = $db->prepare($query);
        $statement->bindValue(':parentId', $parentId);
        $statement->bindValue(':active', 2);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteChildById($childId) {
        $db = Database::getDB();
        $query = 'UPDATE child
                SET active = :active,
                dateMod = now()
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $childId);
        $statement->bindValue(':active', 2);
        $statement->execute();
        $statement->closeCursor();
    }

}

?>