<?php

/**
 * Principal class
 *
 * This class represents a user in the directory tree.
 * Many WebDAV specs require a user to show up in the directory 
 * structure. The principal is defined in RFC 3744.
 * 
 * @package Sabre
 * @subpackage DAV
 * @version $Id$
 * @copyright Copyright (C) 2007-2010 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/) 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class Sabre_DAV_Auth_Principal extends Sabre_DAV_Node implements Sabre_DAV_IProperties {

    /**
     * Full uri for this principal resource 
     * 
     * @var string 
     */
    protected $principalUri;

    /**
     * Struct with principal information.
     *
     * @var array 
     */
    protected $principalProperties;

    /**
     * Creates the principal object 
     *
     * @param string $principalUri Full uri to the principal resource
     * @param array $principalProperties
     */
    public function __construct($principalUri,array $principalProperties = array()) {

        $this->principalUri = $principalUri;
        $this->principalProperties = $principalProperties;

    }

    /**
     * Returns the name of the element 
     * 
     * @return void
     */
    public function getName() {

        return basename($this->principalUri);

    }

    /**
     * Returns the name of the user 
     * 
     * @return void
     */
    public function getDisplayName() {

        if (isset($this->principalProperties['{DAV:}displayname'])) {
            return $this->principalProperties['{DAV:}displayname'];
        } else {
            return $this->getName();
        }

    }

    /**
     * Returns a list of properties 
     * 
     * @param array $requestedProperties 
     * @return void
     */
    public function getProperties($requestedProperties) {

        if (!count($requestedProperties)) {
           
            // If all properties were requested
            // we will only returns properties from this list
            $requestedProperties = array(
                '{DAV:}resourcetype',
                '{DAV:}displayname',
            );

        }

        // We need to always return the resourcetype
        // This is a bug in the core server, but it is easier to do it this way for now
        $newProperties = array(
            '{DAV:}resourcetype' => new Sabre_DAV_Property_ResourceType('{DAV:}principal')
        );
        foreach($requestedProperties as $propName) switch($propName) {
            
            case '{DAV:}alternate-URI-set' :
            case '{DAV:}group-member-set' :
            case '{DAV:}group-membership' :
                $newProperties[$propName] = null;
                break;

            case '{DAV:}principal-URL' :
                $newProperties[$propName] = new Sabre_DAV_Property_Href($this->principalUri);
                break;

            case '{DAV:}displayname' :
                $newProperties[$propName] = $this->getDisplayName();
                break;

            default :
                if (isset($this->principalProperties[$propName])) {
                    $newProperties[$propName] = $this->principalProperties[$propName];
                }
                break;

        }

        return $newProperties;
        

    }

    /**
     * Updates this principals properties.
     *
     * Currently this is not supported
     * 
     * @param array $properties 
     * @return void
     */
    public function updateProperties($properties) {

        throw new Sabre_DAV_Exception_PermissionDenied('Updating properties is not supported');

    }

}
