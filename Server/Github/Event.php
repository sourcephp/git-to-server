<?php
/**
 * Project : simple-php-git-deploy
 * User: thuytien
 * Date: 11/10/2014
 * Time: 12:39 AM sdfasdf
 */

namespace AutoGitPuller\Server\Github;

use AutoGitPuller\Server\BaseEvent;
use AutoGitPuller\Util\Error;

class Event extends BaseEvent{
    //https://developer.github.com/v3/activity/events/types/#pushevent
   public function processRequest($secret = ''){
       $headers = getallheaders();
       $hubSignature = $headers['X-Hub-Signature'];
       $payload = file_get_contents('php://input');
       $data = json_decode($payload);
       if($secret!=='') {
           list($algo, $hash) = explode('=', $hubSignature, 2);
           $payloadHash = hash_hmac($algo, $payload, $secret);
           if ($hash !== $payloadHash) {
               return new Error("","Secret key was not matched.");
           }
       }
       $this->repository = $data->repository;
       //get branch name from ref url
       $refParsed = explode('/',$data->ref);
       $this->repository->branchName = $refParsed[count($refParsed)-1];
       $this->author = $data->commits->committer;
       return true;
   }
    public function getCommiterUsername()
    {
        return $this->author->username?$this->author->username:'';
    }
    public function getRepositoryName(){
        return $this->repository->name?$this->repository->name:'';
    }
    public function getRepositoryBranch(){
        return $this->repository->branchName;
    }
}