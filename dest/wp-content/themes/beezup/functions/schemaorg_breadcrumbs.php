<?php

class SchemaOrg_Breadcrumbs{
    // this class variable is needed to count the links since they have to be nested when using Schema.org markup
    private $breadcrumb_link_counter = 0;

    private $breadcrumb_element_wrapper = 'span';
    private $breadcrumb_output_wrapper = 'span';

    public function __construct(){
        add_filter( 'wpseo_breadcrumb_single_link_wrapper', array( $this, 'breadcrumb_element_wrapper' ), 95 );
        add_filter( 'wpseo_breadcrumb_output_wrapper', array( $this, 'breadcrumb_output_wrapper' ), 95 );
        add_filter( 'wpseo_breadcrumb_single_link', array( $this, 'modify_breadcrumb_element' ), 10, 2 );
        add_filter( 'wpseo_breadcrumb_output', array( $this, 'modify_breadcrumb_output' ) );
    }

    // this function stores the element wrapper in the class so it can be used
    public function breadcrumb_element_wrapper( $element ){
        $this->breadcrumb_element_wrapper = $element;
        return $element;
    }

    // this function stores the overall output wrapper in the class so it can be used
    public function breadcrumb_output_wrapper( $wrapper ){
        $this->breadcrumb_output_wrapper = $wrapper;
        return $wrapper;
    }

    // this function modifies the output for a single link
    public function modify_breadcrumb_element( $link_output, $link ){
        $output = '';
        if( $this->breadcrumb_link_counter >= 0 ){
            $output .= '<' . $this->breadcrumb_element_wrapper . '>';
        }

        if( isset( $link['url'] ) && substr_count( $link_output, 'rel="v:url"' ) > 0 ){
            $output .= '<a href="' . esc_attr( $link['url'] ) . '" itemprop="url"><span itemprop="title">' . $link['text'] . '</span></a>';
        }else{
            $opt = get_wpseo_options();
            if( isset( $opt['breadcrumbs-boldlast'] ) && $opt['breadcrumbs-boldlast'] ){
                $output .= '<strong class="breadcrumb_last" itemprop="title">' . $link['text'] . '</strong>';
            }else{
                $output .= '<span class="breadcrumb_last" itemprop="title">' . $link['text'] . '</span>';
            }
        }
        $this->breadcrumb_link_counter++;

        return $output;
    }

    // this function modifies the overall output
    public function modify_breadcrumb_output( $full_output ){
        $full_output = str_replace( ' xmlns:v="http://rdf.data-vocabulary.org/#"', ' itemprop="breadcrumb" itemscope="itemscope" itemtype="http://schema.org/WebPage"', $full_output );

        $end_offset = strlen( $this->breadcrumb_output_wrapper ) + 3;
        $offset = strlen( $full_output ) - $end_offset;

        $output = substr( $full_output, 0, $offset );

        for( $i = 0; $i < $this->breadcrumb_link_counter - 1; $i++ ){
            $output .= '</' . $this->breadcrumb_element_wrapper . '>';
        }

        $output .= substr( $full_output, $offset, $end_offset );

        return $output;
    }
}

?>