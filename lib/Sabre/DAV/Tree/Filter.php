<?php

/**
 * This class can be used to hook into your tree and override/alter actions
 *
 * This class is not intended to be used on its own, as it just proxies all requests to the sub-tree by default
 * To use it, subclass it and construct the object by passing your underlying tree in the constructor
 *
 * @package Sabre
 * @subpackage DAV
 * @version $Id$
 * @copyright Copyright (C) 2007-2009 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/) 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
abstract class Sabre_DAV_Tree_Filter extends Sabre_DAV_Tree {

    /**
     * subject 
     * 
     * @var Sabre_DAV_Tree 
     */
    protected $subject;

    /**
     * Creates the filtertree 
     * 
     * @param Sabre_DAV_Tree $subject The tree object that needs to be filtered
     * @return void
     */
    public function __construct(Sabre_DAV_Tree $subject) {

        $this->subject = $subject;

    }

    /**
     * Copies a file from path to another
     *
     * @param string $sourcePath The source location
     * @param string $destinationPath The full destination path
     * @return int
     */
    public function copy($sourcePath,$destinationPath) {

        return $this->subject->copy($sourcePath,$destinationPath);

    }

    /**
     * Returns an array with information about nodes 
     * 
     * @param string $path The path to get information about 
     * @param int $depth 0 for just the path, 1 for the path and its children, Sabre_DAV_Server::DEPTH_INFINITY for infinit depth
     * @return array 
     */
    public function getNodeInfo($path,$depth = 0) {

        return $this->subject->getNodeInfo($path,$depth);

    }

    /**
     * Deletes a node based on its path 
     * 
     * @param string $path 
     * @return void
     */
    public function delete($path) {

        return $this->subject->delete($path);

    }

    /**
     * Updates an existing file node 
     *
     * @param string $path 
     * @param resource $data 
     * @return bool
     */
    public function put($path, $data) {

        return $this->subject->put($path,$data);

    }

    /**
     * Creates a new filenode on the specified path
     *
     * @param string $path 
     * @param resource $data 
     * @return bool
     */
    public function createFile($path,$data) {

        return $this->subject->createFile($path,$data);

    }

    /**
     * Creates a new directory 
     * 
     * @param string $path The full path to the new directory 
     * @return void
     */
    public function createDirectory($path) {

        $this->subject->createDirectory($path);

    }

    /**
     * Returns the contents of a node 
     * 
     * This method may either return a string or a readable stream resource.
     *
     * @param string $path 
     * @return mixed 
     */
    public function get($path) {

        return $this->subject->get($path);

    }

    /**
     * Moves a file from one location to another 
     * 
     * @param string $sourcePath The path to the file which should be moved 
     * @param string $destinationPath The full destination path, so not just the destination parent node
     * @return int
     */
    public function move($sourcePath, $destinationPath) {

        return $this->subject->move($sourcePath,$destinationPath);

    }

    /**
     * This function should return true or false, depending on wether or not this WebDAV tree supports locking of files 
     *
     * @return bool 
     */
    public function supportsLocks($path) {

        return $this->subject->supportsLocks($path);

    }

    /**
     * Returns all lock information on a particular uri 
     * 
     * This function should return an array with Sabre_DAV_Lock objects. If there are no locks on a file, return an empty array
     *
     * @param string $path
     * @return array 
     */
    public function getLocks($path) {

        return $this->subject->getLocks($path);

    }

    /**
     * Locks a uri
     *
     * All the locking information is supplied in the lockInfo object. The object has a suggested timeout, but this can be safely ignored
     * It is important that if the existing timeout is ignored, the property is overwritten, as this needs to be sent back to the client
     * 
     * @param string $uri 
     * @param Sabre_DAV_Lock $lockInfo 
     * @return void
     */
    public function lockNode($path, Sabre_DAV_Lock $lockInfo) {

        return $this->subject->lockNode($path,$lockInfo);

    }

    /**
     * Unlocks a uri
     *
     * This method removes a lock from a uri. It is assumed all the correct information is correct and verified
     * 
     * @param string $uri 
     * @param Sabre_DAV_Lock $lockInfo 
     * @return void
     */
    public function unlockNode($path, Sabre_DAV_Lock $lockInfo) {

        return $this->subject->unlockNode($path,$lockInfo);

    }

    /**
     * Updates properties
     *
     * This method will receive an array, containing arrays with update information
     * The secondary array will have the following elements:
     *   0 - 1 = set, 2 = remove
     *   1 - the name of the element
     *   2 - the value of the element, represented as a DOMElement 
     * 
     * This method should return a similar array, except it should only return the name of the element and a status code for every mutation. The statuscode should be
     *   200 - if the property was updated
     *   201 - if a new property was created
     *   403 - if changing/deleting the property wasn't allowed
     *   404 - if a non-existent property was attempted to be deleted
     *   or any other applicable HTTP status code
     *
     * The method can also simply return false, if updating properties is not supported
     *
     * @param string $uri the uri for this operation 
     * @param array $mutations 
     * @return void
     */
    public function updateProperties($uri, $mutations) {

        return $this->subject->updateProperties($uri,$mutations);

    }

    /**
     * Returns a list of properties
     *
     * The returned struct should be in the format:
     *
     *   namespace#tagName => contents
     * 
     * @param string $uri The requested uri
     * @param array $properties An array with properties, if its left empty it should return all properties
     * @return void
     */
    public function getProperties($uri,$properties) {
        
        return $this->subject->getProperties($uri,$properties);

    }


}
