<?php

/**
 * File: RefList
 *
 * This file is part of the Carbon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package RefNotes
 */

namespace RefNotes;

use Closure;
use InvalidArgumentException;

/**
 * A simple API for collecting footnotes
 *
 * Container for collecting notes and references. Use this as
 * a global footnote builder whilst another library is most likely
 * used when parsing your content.
 *
 * @property mixed[] $notes     Stores the list of notes.
 * @property mixed[] $note_data Stores the list of data for note ID.
 */

class RefList
{
	public static $notes = [];
	public static $note_data = [];

	/**
	 * Are there any notes stored?
	 *
	 * @return bool The stored note count
	 */

	public static function has_notes()
	{
		return count( self::$notes );
	}

	/**
	 * Retrieve all note IDs.
	 *
	 * @return array List of note IDs, if available.
	 */

	public static function get_codes()
	{
		if ( empty( self::$notes ) ) {
			return [];
		}

		return array_keys( self::$notes );
	}

	/**
	 * Alias of {@see RefList::get_first_code()}
	 *
	 * @return string|int Empty string, if no note IDs.
	 */

	public static function get_code()
	{
		return self::get_first_code();
	}

	/**
	 * Retrieve first note ID available.
	 *
	 * @return string|int Empty string, if no note IDs.
	 */

	public static function get_first_code()
	{
		$codes = self::get_codes();

		if ( empty( $codes ) ) {
			return '';
		}

		return reset( $codes );
	}

	/**
	 * Retrieve last note ID available.
	 *
	 * @return string|int Empty string, if no note IDs.
	 */

	public static function get_last_code()
	{
		$codes = self::get_codes();

		if ( empty( $codes ) ) {
			return '';
		}

		return end( $codes );
	}

	/**
	 * Retrieve all note messages or note messages matching code.
	 *
	 * @param string|int $code Optional. Retrieve messages matching code, if exists.
	 * @return array Note strings on success, or empty array on failure (if using code parameter).
	 */

	public static function get_messages( $code = '' )
	{
		// Return all messages if no code specified.
		if ( empty( $code ) ) {
			$all_messages = [];

			foreach ( (array) self::$notes as $code => $messages ) {
				$all_messages = array_merge( $all_messages, $messages );
			}

			return $all_messages;
		}

		if ( isset( self::$notes[ $code ] ) ) {
			return self::$notes[ $code ];
		}
		else {
			return [];
		}
	}

	/**
	 * Get single note message.
	 *
	 * This will get the first message available for the code. If no code is
	 * given then the first code available will be used.
	 *
	 * @param string|int $code Optional. Note code to retrieve message.
	 * @return string
	 */

	public static function get_message( $code = '' )
	{
		if ( empty( $code ) ) {
			$code = self::get_code();
		}

		$messages = self::get_messages( $code );

		if ( empty( $messages ) ) {
			return '';
		}

		return $messages[0];
	}

	/**
	 * Retrieve note data for note ID.
	 *
	 * @param string|int $code Optional. Note code.
	 * @return mixed Null, if no notes.
	 */

	public static function get_data( $code = '' )
	{
		if ( empty( $code ) ) {
			$code = self::get_code();
		}

		if ( isset( self::$note_data[ $code ] ) ) {
			return self::$note_data[ $code ];
		}

		return null;
	}

	/**
	 * Add a note or append additional message to an existing note.
	 *
	 * @param string $message Note message.
	 * @param string|int $code Note code.
	 * @param mixed[] $data Optional. Note data.
	 *
	 * @return string|int Returns the last $code used, useful for auto-incremented notes.
	 */

	public static function add( $message, $code = null, array $data = [] )
	{
		if ( empty( $code ) ) {
			$code = count( self::$notes ) + 1;
		}

		self::$notes[ $code ][] = $message;

		if ( ! empty( $data ) ) {
			self::$note_data[ $code ] = ( is_array( $data ) ? $data : [] );
		}

		return $code;
	}

	/**
	 * Add data for note ID.
	 *
	 * @see RefListL::append_data() To modify/expand a note's dataset,
	 *
	 * @param mixed[] $data Note data.
	 * @param string|int $code Note code.
	 */

	public static function add_data( array $data, $code = '' )
	{
		if ( empty( $code ) ) {
			$code = self::get_code();
		}

		self::$note_data[ $code ] = $data;
	}

	/**
	 * Append and modify data for note ID.
	 *
	 * @param mixed[] $data Note data.
	 * @param string|int $code Note code.
	 */

	public static function append_data( array $data, $code = '' )
	{
		if ( empty( $code ) ) {
			$code = self::get_code();
		}

		if ( empty( self::$note_data[ $code ] ) ) {
			$__data = [];
		}

		if ( isset( self::$note_data[ $code ] ) ) {
			self::$note_data[ $code ] = array_merge( self::$note_data[ $code ], $data );
		}
		else {
			self::$note_data[ $code ] = $data;
		}
	}

	/**
	 * Removes the specified note.
	 *
	 * This function removes all note messages associated with the specified
	 * note ID, along with any note data for that code.
	 *
	 * @param string|int $code Note code.
	 */

	public static function remove( $code )
	{
		unset( self::$notes[ $code ] );
		unset( self::$note_data[ $code ] );
	}
}
