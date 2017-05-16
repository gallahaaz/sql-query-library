<?php namespace Gallahaaz\SqlQueryLibrary;

use Gallahaaz\SqlQueryLibrary\Connection as Connection;

class Query extends Connection
{   
    private $sqlCommands = [
        'NOW()',
        'CURDATE()',
        'CURTIME()'
    ];
    public $last_id = null;
    
    public function query( $cmd ) {
        $this->connect();
        $this->result = $this->DB->query( $cmd );
        if ( isset($this->DB->insert_id ) ) {
            $this->last_id = $this->DB->insert_id;
        }
         $this->close();
        return $this->result;
    }
    
    public function getLastId(){
        return $this->last_id;
    }

    public function fetch( $result, $method = MYSQLI_BOTH, $index = null ) {
        $array = array();
        $c=0;
        while( $reg = $result->fetch_array( $method ) ){
            if( isset( $index ) ){
                $array[ $reg[$index] ] = $reg;
            }else{
                $array[$c] = $reg;
                $c++;
            }
        }
        return $array;
    }
    
    public function fetchDecode( $result, $method = MYSQLI_BOTH, $index = null ) {
        $array = array();
        $c=0;
        while( $reg = $result->fetch_array($method) ){
            if( isset( $index ) ){
                $array[ $reg[$index] ] = urldecode( $reg );
            }else{
                foreach($reg as $key => $value ){
                    $array[$c][$key] = urldecode( $value );
                }
                $c++;
            }
        }
        return $array;
    }

    public function fetchSingle( $result, $method = MYSQLI_BOTH ) {
        return $result->fetch_array($method);
    }

    public function select( $fields, $table, $searchFields = null, $options = null ){
            $cmd = 'SELECT '
            . $this->concatArray( $fields )
            . ' FROM '
            . $table;
        if( isset( $searchFields ) ){
            $cmd .= ' WHERE '
                . $this->concatMatriz( $searchFields );
        };
        if( isset( $options ) ){
            $cmd .= $options;
        }
        return $this->query( $cmd );   
    }

    public function insert( $table, $columns, $values ){
        $cmd = 'INSERT INTO '
        	. $table . '( '
            . $this->concatArray( $columns )
            . ' ) VALUES ( '
            . $this->concatArrayValues( $values )
            . ' ); ';
        return $this->query( $cmd );
    }
    
    public function update( $table, $set, $where ){
        $cmd = 'UPDATE ' 
        	. $table 
            . ' SET '
            . $this->concatSet( $set )
            . ' WHERE '
            . $this->concatMatriz( $where );
        return $this->query( $cmd );
    }
    
    public function delete( $table, $where ){
        $cmd = 'DELETE FROM '
            . $table
            . ' WHERE '
            . $this->concatMatriz( $where );
        return $this->query($cmd);
    }
    
    public function search( $command, $page = 0, $defaultquant = 12 ) {
        $counter = $this->query( $command );
        $cmd = $command . " LIMIT " . ( $page * $defaultquant ) . "," . $defaultquant . ";";
        $request = $this->query($cmd);
        $c = 0;
        while ($reg = $request->fetch_array(MYSQLI_ASSOC)) {
            foreach ( $reg as $key => $value ) {
                $SearchResult[$c][$key] = $value;
            }
            $c++;
        }
        $SearchResult['Rows'] = $counter->num_rows;
        if ($c === 0) {
            return FALSE;
        } else {
            return $SearchResult;
        }
    }
    
    public function concatArray( $array ){
        $string = '';
        $c = 0;
        $last = count( $array );
        foreach( $array as $key ){
            if( ( $c >= 1 ) &&( $c<$last ) ){
                $string .= ',' ;
                $string .= $key;
            }else{
                $string .= $key;
            }
            $c++;
        }
        return $string;
    }
    
    public function concatArrayValues( $array ){
        $string = '';
        $c = 0;
        $last = count( $array );
        foreach( $array as $key ){
            if( ( $c >= 1 ) &&( $c<$last ) ){
                if( is_integer($key) || is_float($key) ){
                    $string .= ", " . str_replace( ',', '.', $key);
                }else{
                    if( in_array( $key, $this->sqlCommands ) ){
                        $string .= ", " . $key . " ";
                    }else{
                        $string .= ", '" . $key . "' ";
                    }
                }
            }else{
                if( is_integer($key) || is_float($key) ){
                    $string .= $key ;
                }else{
                    $string .= " '" . $key . "' ";
                }
            }
            $c++;
        }
        return $string;
    }
    
    public function concatMatriz( $array ){
        $string = '';
        $c = 0;
        $last = count( $array );
        foreach( $array as $key => $value ){
            if( isset( $value ) ){
                if( ( $c >= 1 ) &&( $c < $last ) ){
                    $string .= ' AND ' ;
                }
                $string .= $key . ' = ' . chr(39) .  $value . chr(39);
                $c++;
            }
        }
        return $string;
    }

    public function concatSet( $matriz ){
        $string = '';
        $c = 0;
        $last = count( $matriz );
        foreach( $matriz as $key => $value ){
            if( isset( $value ) ){
                if( ( $c >= 1 ) &&( $c < $last ) ){
                    $string .= ', ' ;
                }
                $string .= $key . ' = ' . chr(39) .  $value . chr(39);
                $c++;
            }
        }
        return $string;
    }

    public function call( $procedure, $arguments, $single = false ){
        $cmd = "CALL " . $procedure . "( "
            . $this->concatArrayValues($arguments)
            .")";
        if( !$single ){
            return $this->query($cmd);
        }else{
            $result = $this->query($cmd);
            $array = $result->fetch_array( MYSQLI_ASSOC );
            return array_shift( $array );
        }
    }

}