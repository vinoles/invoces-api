<?php

// src/Entity/FileLogoBranchOffice.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateFileLogoBranchOfficeAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="file_logo_branch_office")
 * @ORM\Entity
 * @ApiResource(
 * description= "Entidad para gestionar el logo de una empresa,
 * se envia por medio de un formato Content-Type: multipart/form-data",
 * iri="http://schema.org/FileLogoBranchOffice",
 *  collectionOperations={
 *     "get",
 *     "post"={
 *         "method"="POST",
 *         "path"="/file_logo_branch_offices",
 *         "controller"=CreateFileLogoBranchOfficeAction::class,
 *         "defaults"={"_api_receive"=false},
 *     },
 * })
 * @Vich\Uploadable
 */
class FileLogoBranchOffice
{

    /**
     * @var int The id of this branch_office.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File|null
     * @Assert\NotNull()
     * @Vich\UploadableField(mapping="file_logo_branch_office", fileNameProperty="contentUrl")
     */
    public $file;

    /**
     * @var string|null
     * @ORM\Column(nullable=false)
     * @ApiProperty(iri="http://schema.org/contentUrl")
     */
    public $contentUrl;


    public function getId()
    {
        return $this->id;
    }
}
