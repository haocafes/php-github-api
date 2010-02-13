<?php

require_once(dirname(__FILE__).'/phpGitHubApiRequest.php');

/**
 * Simple PHP GitHubAPI class. API documentation should be self-explanatory.
 *
 * @author	Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license	MIT License
 */

class phpGitHubApi
{
  protected
  $requestClass = 'phpGitHubApiRequest',
  $login,
  $token;

  /*
   * Instanciates a new API
   *
   * @param  string   $login  GitHub username
   * @param  string   $token  GitHub password
   */
  public function __construct($login = null, $token = null)
  {
    $this->authenticate($login, $token);
  }

  /*
   * Authenticates a user for all next requests
   *
   * @param  string         $login  GitHub username
   * @param  string         $token  GitHub password
   * @return phpGitHubApi   $this   Fluent interface
   */
  public function authenticate($login, $token)
  {
    $this->login = $login;
    $this->token = $token;

    return $this;
  }

  /*
   * Search users by username
   * http://develop.github.com/p/users.html#searching_for_users
   *
   * @param   string  $username       the username to search
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function searchUsers($username, array $requestOptions = array())
  {
    $data = $this->createRequest($requestOptions)->get('user/search/'.$username);

    return $data['users'];
  }

  /*
   * Get extended information on a user by its username
   * http://develop.github.com/p/users.html#getting_user_information
   *
   * @param   string  $username       the username to search
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function showUser($username, array $requestOptions = array())
  {
    $data = $this->createRequest($requestOptions)->get('user/show/'.$username);

    return $data['user'];
  }

  /*
   * Creates a new request
   *
   * @param array $options  the request options
   */
  protected function createRequest(array $options = array())
  {
    $options = array_merge(array(
      'login' => $this->login,
      'token' => $this->token
    ), $options);
    
    return new $this->requestClass($options);
  }

}