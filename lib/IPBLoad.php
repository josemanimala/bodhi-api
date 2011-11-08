<?PHP
class IPBLoad
{
	/**
	     * initialisation function to setup IPSregistry
	     */
	    protected function init()
	    {
		/**
		 * Edit this path, to where you have your forum installed.
		 */
		$forum_path = '/var/www/forums.bodhilinux.com/public_html/';

		/**
		* We will change directories so that proper directory is picked up
		*/
		chdir( $forum_path );

		/**
		* Get some basic IPB files
		*/
		define( 'IPB_THIS_SCRIPT', 'public' );
		require_once( $forum_path . 'initdata.php' );

		/**
		* Get IPB registry
		*/
		require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
		require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );

		/**
		 * initialise the ipsRegistry
		 */
		$this->ipbRegistry    = ipsRegistry::instance();
		$this->ipbRegistry->init();
	    }
	public function authenticateMember($username,$password)
	{
		$this->init();
		return IPSMember::authenticateMember($username,$password);
	}
	public function loadMember($username,$password)
	{
		$this->init();
		$val = IPSMember::authenticateMember($username,$password);
		if($val==true)
		{
			return IPSMember::load($username,'all','email');
		}
		else
		{
			return 0;
		}
	}	
}
?>