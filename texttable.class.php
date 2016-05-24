<?php

/***
 * A class to print text in formatted tables.
 */
class texttable {

    /**
     * Formats a fixed-width text table, with borders.
     *
     * @param $rows  array of rows.  each row contains table cells.
     * @param $headertype  keys | firstrow | none/null 
     * @param $footertype  keys | lastrow | none/null
     * @param $empty_row_string  String to use when there is no data, or null.
     */
    static public function table( $rows, $headertype = 'keys', $footertype = 'none', $empty_row_string = 'No Data' ) {
        
        if( !@count( $rows ) ) {
            
            if( $empty_row_string !== null ) {
                $rows = [ [ $this->empty_row_string ] ];
            }
            else {
                return '';
            }
        }

        $header = $footer = null;
        if( $headertype == 'keys' ) {        
            $header = array_keys( self::obj_arr( $rows[0] ) );
        }
        else if( $headertype == 'firstrow' ) {
            $header = self::obj_arr( array_shift( $rows ) );
        }
        if( $footertype == 'keys' && count( $rows ) ) {
            $footer = array_keys( self::obj_arr( $rows[count($rows) - 1] ) );
        }
        else if( $footertype == 'lastrow' && count( $rows ) ) {
            $footer = self::obj_arr( array_pop( $rows ) );
        }
        
        $col_widths = array();
        
        if( $header ) {
            self::calc_row_col_widths( $col_widths, $header );
        }
        if( $footer ) {
            self::calc_row_col_widths( $col_widths, $footer );
        }
        foreach( $rows as $row ) {
            $row = self::obj_arr( $row );
            self::calc_row_col_widths( $col_widths, $row );
        }
        
        $buf = '';
        if( $header ) {        
            $buf .= self::print_divider_row( $col_widths );
            $buf .= self::print_row( $col_widths, $header );
        }
        $buf .= self::print_divider_row( $col_widths );
        foreach( $rows as $row ) {
            $row = self::obj_arr( $row );
            $buf .= self::print_row( $col_widths, $row );
        }
        $buf .= self::print_divider_row( $col_widths );
        if( $footer ) {        
            $buf .= self::print_row( $col_widths, $footer );
            $buf .= self::print_divider_row( $col_widths );
        }
        
        return $buf;
    }
    
    static protected function print_divider_row( $col_widths ) {
        $buf = '+';
        foreach( $col_widths as $width ) {
            $buf .= '-' . str_pad( '-', $width, '-' ) . "-+";
        }
        $buf .= "\n";
        return $buf;
    }
    
    static protected function print_row( $col_widths, $row ) {
        $buf = '|';
        $idx = 0;
        foreach( $row as $val ) {
            $pad_type = is_numeric( $val ) ? STR_PAD_LEFT : STR_PAD_RIGHT;
            $buf .= ' ' . str_pad( $val, $col_widths[$idx], ' ', $pad_type ) . " |";
            $idx ++;
        }
        return $buf . "\n";
    }

    static protected function calc_row_col_widths( &$col_widths, $row ) {
        $idx = 0;
        foreach( $row as $val ) {
            $len = strlen( $val );
            if( $len > @$col_widths[$idx] ) {
                $col_widths[$idx] = $len;
            }
            $idx ++;
        }
    }
    
    static protected function obj_arr( $t ) {
       return is_object( $t ) ? get_object_vars( $t ) : $t;
    }
}
