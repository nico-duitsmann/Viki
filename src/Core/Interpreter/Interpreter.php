<?php

include('Matching.php');

/**
 * Parse and process user input.
 *
 * @param string $input
 * @param array $vml
 * @param string $value
 * @return void
 */
function parse_input(string $input, array $vml, string $value) {
    $result = array(
        'input' => $input,
        'output' => '',
        'neuron' => ''
    );

    for ( $iter = 0; $iter < sizeof($vml); $iter++ ) {
        if ( is_in( $input, $vml[$iter]['input'] ) ) {
            // Check if input contains multiple responses
            if ( isset( $vml[$iter]['output'][0] ) ) {
                $num_resp = count( $vml[$iter]['output'] ); // Count number of responses
                // Randomly choose response
                $rdm_resp = rand(0, $num_resp - 1); // -1 because array starts at 0

                $result['output'] = @$vml[$iter]['output'][$rdm_resp][$value];
                $result['neuron'] = $vml[$iter]['input'];
                return $result;
                break;
            } else {
                $result['output'] = @$vml[$iter]['output'][$value];
                $result['neuron'] = $vml[$iter]['input'];
                return $result;
                break;
            }
        }
    }
}

/**
 * Format constants in string.
 *
 * @param string $input
 * @param [type] $answer
 * @param [type] $neuron
 * @param string $const
 * @return string
 */
function const_format(string $input, $answer, $neuron, string $const): string {
    $answer == null ? $answer = 'I have no answer for that.': $answer;
    $neuron == null ? $neuron = '': $neuron;

    if ( is_in($const, $answer) ) {
        $add_input = get_additional_input($input, $neuron);
        $add_input = trim(preg_replace('/\s\s+/', ' ', $add_input));
        $replaced = str_replace($const, $add_input, $answer);
        return $replaced;
    } else {
        return $answer;
    }
}

/**
 * Get'S additional input.
 *
 * @param string $input
 * @param string $neuron
 * @return string
 */
function get_additional_input(string $input, string $neuron): string {
    $str_len_input  = trim(strlen($input));
    $str_len_neuron = trim(strlen($neuron));

    if ( $str_len_input == $str_len_neuron ) {
        return $input.PHP_EOL;
    } else {
        $str_len_diff = $str_len_input - $str_len_neuron;
        return trim(substr($input, ($str_len_input - $str_len_diff), $str_len_diff)).PHP_EOL;
    }
}
