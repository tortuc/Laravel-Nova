<?php

namespace App\Revenuedriver;

use App\Revenuedriver\Base\Facebook;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Fields\CampaignFields;

class FacebookAdCreative extends Facebook
{
     
    /**
     * @var int
     */
    protected $showAttempts = 0;

    /**
     * @var int
     */
    protected $createAttempts = 0;

    /**
     * @param string $adCreativeId
     * @param array $params=[]
     * @param array $fields=[]
     * 
     * @return array
     */
    public function show(string $adCreativeId, array $params=[], array $fields=[]): array
    {  
       
        try {
           $adCreative = (new AdCreative($adCreativeId))->getSelf($params, $fields);
           return [true, $adCreative];
        } catch(\FacebookAds\Http\Exception\ClientException | \FacebookAds\Http\Exception\EmptyResponseException |
            \FacebookAds\Http\Exception\ServerException $e) 
        {
            if ($this->showAttempts < 5) {
                $this->showAttempts++;
                return $this->show($adCreativeId, $params, $fields);
            } 
            return [false, $e];
        } catch (\Throwable $th) {
            return [false, $th];
        }
    }

    /*
     * Create a new campaign
     * 
     * @param string $accountId
     * @param array $params
     * @param array $fields
     * 
     * @return Response
     */
    public function create(string $accountId, array $params, array $fields=[])
    { 
        $account = new AdAccount($accountId);
        try {
            $adCreative = $account->createAdCreative($fields, $params);
            return [true, $adCreative];
        } catch(\FacebookAds\Http\Exception\ClientException | \FacebookAds\Http\Exception\EmptyResponseException |
            \FacebookAds\Http\Exception\ServerException $e) 
        {
            if ($this->createAttempts < 5) {
                $this->createAttempts++;
                return $this->create($accountId, $params, $fields);
            } 
            return [false, $e];
        } 
        catch (\Throwable $th) {
            return[false, $th];
        } 
     }
 

}