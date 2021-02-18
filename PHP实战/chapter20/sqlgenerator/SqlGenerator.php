<?php
abstract class ObjectConverter {
    abstract public function convert(DomainObject $object);
    abstract public function TABLE_NAME();
    abstract public function ID_COLUMN();
}

class TopicConverter extends ObjectConverter {
    public function convert(DomainObject $topic) {
        return array(
                'id' => $topic->getID(), 
                'name' => "'".$topic->getName()."'"
                );
    }
    public function TABLE_NAME() { return 'Topics'; }
    public function ID_COLUMN() { return 'id'; }
}

class AutoSqlGenerator {

    public static function getConverterFor(DomainObject $object) {
        if ($object instanceof Topic) return new TopicConverter;
        if ($object instanceof Customer) return new CustomerConverter;
    }

    public function makeInsertStatement(DomainObject $object) {
        $converter = self::getConverterFor($object);
        $rowData = $converter->convert($object);
        $columns = join(',',array_keys($rowData));
        $values = join(',',array_values($rowData));
        return "INSERT INTO ".$converter->TABLE_NAME().
            " ($columns) VALUES ($values)";
    }
    public function makeUpdateStatement(DomainObject $object) {
        $converter = self::getConverterFor($object);
        $rowData = $converter->convert($object);
        foreach ($rowData as $key => $value) {
            $entries[] = "$key = $value";
        }
        return "UPDATE ".$converter->TABLE_NAME().
            " SET ".join(', ',$entries).
            " WHERE ".$converter->ID_COLUMN().
            " = ".$rowData['id'];
    }

    public function makeDeleteStatement(DomainObject $object) {
        $converter = self::getConverterFor($object);
        $rowData = $converter->convert($object);
        return "DELETE FROM ".$converter->TABLE_NAME().
            " WHERE ".$converter->ID_COLUMN().
            " = ".$rowData['id'];
    }
}

class ObjectSqlGenerator {

    private $converter;
    
    public function __construct(ObjectConverter $converter) {
        $this->converter = $converter;
    }

    public function makeInsertStatement(DomainObject $object) {
        $rowData = $this->converter->convert($object);
        $columns = join(',',array_keys($rowData));
        $values = join(',',array_values($rowData));
        return "INSERT INTO ".$this->converter->TABLE_NAME().
            " ($columns) VALUES ($values)";
    }
    public function makeUpdateStatement(DomainObject $object) {
        $rowData = $this->converter->convert($object);
        foreach ($rowData as $key => $value) {
            $entries[] = "$key = $value";
        }
        return "UPDATE ".$this->converter->TABLE_NAME().
            " SET ".join(', ',$entries).
            " WHERE ".$this->converter->ID_COLUMN().
            " = ".$rowData['id'];
    }

    public function makeDeleteStatement(DomainObject $object) {
        $rowData = $this->converter->convert($object);
        return "DELETE FROM ".$this->converter->TABLE_NAME().
            " WHERE ".$this->converter->ID_COLUMN().
            " = ".$rowData['id'];
    }
}

class SqlGenerator {

    public static function makeInsertStatement($table,$rowData) {
        $columns = join(',',array_keys($rowData));
        $values = join(',',array_values($rowData));
        return "INSERT INTO $table ($columns) VALUES ($values)";
    }
    public static function makeUpdateStatement($table,$rowData) {
        foreach ($rowData as $key => $value) {
            $entries[] = "$key = $value";
        }
        return "UPDATE $table SET ".join(', ',$entries).
            " WHERE id = ".$rowData['id'];
    }
}

class QuotingSqlGenerator {

    public static function prepareValue($value) {
        if (is_numeric($value)) return $value;
        return "'$value'";

    }
    public static function makeInsertStatement($table,$rowData) {
        $columns = join(',',array_keys($rowData));
        foreach ($rowData as $value) {
            $values[] = self::prepareValue($value);
        }
//        $values = array_map(array('QuotingSqlGenerator','prepareValue'),
//                array_values($rowData));
        return "INSERT INTO $table ($columns) VALUES (".
            join(',',$values).")";
    }
    public static function makeUpdateStatement($table,$rowData) {
        foreach ($rowData as $key => $value) {
            $entries[] = "$key = ".self::prepareValue($value);
        }
        return "UPDATE $table SET ".join(', ',$entries).
            " WHERE id = ".$rowData['id'];
    }

}

?>
