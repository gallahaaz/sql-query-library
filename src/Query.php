<?php namespace Gallahaaz\SqlQueryLibrary;

use Gallahaaz\SqlQueryFinance\Connection as Connection;

class Query extends Connection
{
    
    public function query( $cmd ) {
        $this->connect();
        $this->result = $this->DB->query($cmd);
        if ( isset($this->DB->insert_id ) ) {
            $this->last_id = $this->DB->insert_id;
        }
        $this->close();
        return $this->result;
    }
    
    public function queryFetch($cmd) {
        $request = $this->query($cmd);
        $this->result = $request->fetch_array(MYSQLI_ASSOC);
        return $this->result;
    }
    
    public function insert( $table, $columns, $values ){
        $cmd = 'INSERT INTO '
        	. $table . '( '
            . $this->concatArray( $columns )
            . ' ) VALUES ( '
            . $this->concatArray( $values )
            . ' ); ';
        return $this->query( $cmd );
    }
    
    public function update( $table, $set, $where ){
        $cmd = 'UPDATE ' 
        	. $table 
            . ' SET '
            . $this->concatMatriz( $set )
            . ' WHERE '
            . $where;
        return $this->query( $cmd );
    }
    
    public function delete( $table, $where ){
        $cmd = 'DELETE FROM '
            . $table
            . ' WHERE '
            . $where ;
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
            $string .= $key;
            if( ( $c >= 1 ) &&( $c<$last ) ){
                $string .= ',' ;
            }
        }
        return $string;
    }
    
    public function concatMatriz( $array ){
        $string = '';
        $c = 0;
        $last = count( $array );
        foreach( $array as $key => $value ){
            $string .= $key . '=' . $value;
            if( ( $c >= 1 ) &&( $c<$last ) ){
                $string .= ',' ;
            }
        }
        return $string;
    }
}