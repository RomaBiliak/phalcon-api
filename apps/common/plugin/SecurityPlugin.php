<?php
declare(strict_types=1);
namespace Apps\Common\Plugin;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{


        if (!is_file('app/security/acl.data')) {
            $acl = new AclList();

            $acl->setDefaultAction(Acl::DENY);

            // Register roles
            $roles = [
                'establishment'  => new Role(
                    'Establishment',
                    'Member privileges, granted after sign in.'
                ),
                /*'guests' => new Role(
                    'Guests',
                    'Anyone browsing the site who is not signed in is considered to be a "Guest".'
                )*/
            ];

            foreach ($roles as $role) {
                $acl->addRole($role);
            }


            //Private area resources
            $privateResources = [
                'login'            => ['login'],
                'personal'         => ['getPersonalData','addPersonalData','editPersonalData'],
                'scheme'           => ['getSheme','addSheme','editSheme','deleteSheme'],


            ];
            foreach ($privateResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

           

            //Grant access to private area to role Users
            foreach ($privateResources as $resource => $actions) {
                foreach ($actions as $action){
                    $acl->allow('Establishment', $resource, $action);
                }
            }

            file_put_contents(
                SECURITY_PATH .'/acl.data',
                serialize($acl)
            );
        } else {
            $acl = unserialize(
                file_get_contents(SECURITY_PATH .'/acl.data')
            );
        }

		return $acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
	    $role = $this->getRole();

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();

		$acl = $this->getAcl();

		if (!$acl->isResource($controller)) {
            $this->api_response->sendError(404);
			return false;
		}

		$allowed = $acl->isAllowed($role, $controller, $action);
		if (!$allowed) {

            $this->api_response->sendError(401);
			return false;
		}
	}


    public function getRole():string
    {
        $jwt = $this->JWT->getJWTData();
        if(isset($jwt->admin_id)) return 'Admin';
        if(isset($jwt->establishment_id)) return 'Establishment';
        if(isset($jwt->user_id)) return 'User';
        return 'Guest';
    }
}
