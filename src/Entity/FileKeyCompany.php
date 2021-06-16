<?php

// src/Entity/FilekeyCompany.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateFileKeyCompanyAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Table(name="file_key_company")
 * @ORM\Entity
 * @ApiResource(
 * description= "Entidad para gestionar la clave privada para firmar las facturas de una empresa,
 * se envia por medio de un formato Content-Type: multipart/form-data",
 * iri="http://schema.org/FileKeyCompany",
 *  collectionOperations={
 *     "get",
 *     "post"={
 *         "method"="POST",
 *         "path"="/file_key_companies",
 *         "controller"=CreateFileKeyCompanyAction::class,
 *         "defaults"={"_api_receive"=false},
 *     },
 * })
 * @Vich\Uploadable
 */
class FileKeyCompany
{

    /**
     * @var int The id of this company.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File|null
     * @Assert\NotNull()
     * @Vich\UploadableField(mapping="file_key_company", fileNameProperty="contentUrl")
     */
    public $file;

    /**
     * @var string|null
     * @ORM\Column(nullable=false)
     * @ApiProperty(iri="http://schema.org/contentUrl")
     */
    public $contentUrl;

    /**
     * @var string|null
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @ApiProperty(iri="http://schema.org/password")
     */
    public $password;


    public function getId()
    {
        return $this->id;
    }
}
