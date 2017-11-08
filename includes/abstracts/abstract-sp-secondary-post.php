<?php
/**
 * Abstract Secondary Post Class
 *
 * The SportsPress secondary post class extends custom posts with handling of secondary post types.
 *
 * @class 		SP_Secondary_Post
 * @version		2.5
 * @package		SportsPress/Abstracts
 * @category	Abstract Class
 * @author 		ThemeBoy
 */
abstract class SP_Secondary_Post extends SP_Custom_Post {

  /** @var string The date filter for events. */
  public $date = 0;

  /** @var string The date to range from. */
  public $from = 'now';

  /** @var string The date to range to. */
  public $to = 'now';

  /** @var string The number of days to query in the past. */
  public $past = 0;

  /** @var string The number of days to query in the future. */
  public $future = 0;

  /** @var boolean Determines whether the date range is relative. */
  public $relative = false;

  public function range( $where = '', $format = 'Y-m-d' ) {
    $from = new DateTime( $this->from, new DateTimeZone( get_option( 'timezone_string' ) ) );
    $to = new DateTime( $this->to, new DateTimeZone( get_option( 'timezone_string' ) ) );
    $to->modify( '+1 day' );
    $where .= " AND post_date BETWEEN '" . $from->format( $format ) . "' AND '" . $to->format( $format ) . "'";
    return $where;
  }

  public function relative( $where = '', $format = 'Y-m-d' ) {
    $datetimezone = new DateTimeZone( get_option( 'timezone_string' ) );
    $from = new DateTime( 'now', $datetimezone );
    $to = new DateTime( 'now', $datetimezone );

    $from->modify( '-' . abs( (int) $this->past ) . ' day' );
    $to->modify( '+' . abs( (int) $this->future ) . ' day' );

    $to->modify( '+1 day' );

    $where .= " AND post_date BETWEEN '" . $from->format( $format ) . "' AND '" . $to->format( $format ) . "'";

    return $where;
  }
}
