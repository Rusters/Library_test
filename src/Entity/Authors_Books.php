<?php

namespace App\Entity;

use App\Repository\AuthorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use MongoDB\BSON\Persistable;

class Authors_Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="authors_id", type="integer")
     */
    private $authors_id;

    /**
     * @ORM\Column(name="authors_id", type="integer")
     */
    private $books_id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Books", inversedBy="authors")
     * @ORM\JoinTable(name="authors_books")
     * @ORM\JoinColumn(name="books_id", referencedColumnName="id", onDelete="CASCADE")
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
