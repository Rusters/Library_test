<?php

namespace App\Entity;

use App\Repository\AuthorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use MongoDB\BSON\Persistable;

/**
 * @ORM\Entity(repositoryClass=AuthorsRepository::class)
 */
class Authors
{
    /**
     * Many authors have many books
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Books", inversedBy="authors")
     * @ORM\JoinTable(name="authors_books")
     */
    private $books;

    public function getBooks(): PersistentCollection
    {
        return $this->books;
    }

    public function addBooks (Books $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }
        return $this;
    }

    public function removeBooks (Books $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
