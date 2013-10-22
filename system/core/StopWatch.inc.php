<?php
/* --------------------------------------------------------------
   StopWatch.inc.php 2011-02-22 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/*
 * Class to 
 */
class StopWatch
{
    /*
     * Total time
     */
    var $v_total_time = 0;
    /*
     * Start time
     */
    var $v_start_time = 0;
    /*
     * Stop time
     */
    var $v_stop_time = 0;
	/*
     * Warning time limit
     */
    var $v_warning_time_limit = 0;

    /*
     * constructor
     */
    function StopWatch($p_warning_time_limit = 0.01)
    {
		$this->v_warning_time_limit = (double)$p_warning_time_limit;
    }

    /*
     * Start the stopwatch and set the start time to now and stop time to 0
     * @return bool true
     */
    function start()
    {
        $this->v_start_time = microtime(true);
        $this->v_stop_time = 0;
        return true;
    }

    /*
     * Set the stop time to now and added the different to total_time.
     * @return bool true
     */
    function stop()
    {
        $this->v_stop_time = microtime(true);
        $this->v_total_time += $this->v_stop_time - $this->v_start_time;
        return true;
    }

    /*
     * If stop time not set, returns the time between now and starttime.
     * Else the time between stop- and starttime
     * @return float Current time
     */
    function get_current_time()
    {
        $t_output_value = 0;

        $t_output_value = $this->v_stop_time - $this->v_start_time;
        if($this->v_stop_time == 0) {
            $t_output_value = microtime(true) - $this->v_start_time;
        }

		$t_output_value = number_format($t_output_value, 6);
        return $t_output_value;
    }

    /*
     * Logs the current time
     * @param string $p_debug_notice  Debug notice
     * @return bool true
     */
    function log_current_time($p_debug_notice)
    {
        // Get the current time
        $t_exec_time = $this->get_current_time();
        // Log the time
        if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('execution time (secs): '.$t_exec_time.(($t_exec_time >= $this->v_warning_time_limit) ? ' !!!' : '').' '.$p_debug_notice.' in ['.gm_get_env_info('REQUEST_URI').']', 'StopWatch');
        return true;
    }

    /*
     * Get the current time
     * @return float Total time
     */
    function get_total_time()
    {
		$t_output = number_format($this->v_total_time, 6);
        return $t_output;
    }

    /*
     * Log total time
     * @param string $p_debug_notice Debug notice
     * @return bool true;
     */
    function log_total_time($p_debug_notice)
    {
        // Get total time
        $t_exec_time = $this->get_total_time();
        // Log the time
        if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('execution time (secs): '.$t_exec_time.(($t_exec_time >= $this->v_warning_time_limit) ? ' !!!' : '').' '.$p_debug_notice.' in ['.gm_get_env_info('REQUEST_URI').']', 'StopWatch');
        return true;
    }
}
?>