<?php

namespace App\Services;

use App\Entity\Cat;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class CatmashHandler
 * @package App\Services
 */
class CatmashHandler
{
    private $em;
    private $cr;
    private $catsCollectionUrl;

    /**
     * CatmashHandler constructor.
     * @param string $catsCollectionUrl
     * @param CatRepository $cr
     * @param EntityManagerInterface $em
     */
    public function __construct(string $catsCollectionUrl, CatRepository $cr, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cr = $cr;
        $this->catsCollectionUrl = $catsCollectionUrl;
    }

    /**
     * @return bool
     */
    public function importCatsFromExternalLibrary() : array
    {
        //get cats collection from external service
        $httpClient = HttpClient::create();
        $catsCollection = json_decode($httpClient->request('GET', $this->catsCollectionUrl)->getContent())->images;
        $inserted = $updated = 0;

        if(!empty($catsCollection)) {

            try {
                //deactivate all Cats
                $this->deactivateAllCats();

                //reset viewed count
                $this->resetViewedCount();

                //new cats collection importation
                foreach ($catsCollection as $cat) {

                    $existingCat = $this->em->getRepository("App:Cat")->findOneByRef($cat->id);

                    //activate existing cat or insert it
                    if($existingCat) {

                        $existingCat->setIsActive(true);

                        $this->em->persist($existingCat);
                        $this->em->flush();

                        $updated++;

                    } else {
                        $newCat = new Cat();

                        $newCat->setRef($cat->id);
                        $newCat->setUrl($cat->url);
                        $newCat->setViewedCount(0);
                        $newCat->setVotedCount(0);
                        $newCat->setIsActive(true);

                        $this->em->persist($newCat);
                        $this->em->flush();

                        $inserted++;
                    }
                }
            } catch (Exception $e) {
                echo 'Exception : ',  $e->getMessage(), "\n";
            }
        }

        return [
            "success" => true,
            "inserted" => $inserted,
            "updated" => $updated
        ];
    }

    /**
     *
     */
    public function deactivateAllCats() : void
    {
        $this->cr->deactivateAllCats();
    }

    /**
     *
     */
    public function resetViewedCount() : void
    {
        $this->cr->resetViewedCount();
    }
}