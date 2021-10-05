<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Authors", inversedBy="books")
     * @ORM\JoinTable(name="authors_books")
     */
    private $authors;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Categories", inversedBy="books")
     * @ORM\JoinTable(name="categories_books")
     */
    private $categories;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
    public function __construct() {
        $this->authors = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getAuthors(): PersistentCollection
    {
        return $this->authors;
    }
    public function addAuthors (Authors $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }
        return $this;
    }
    public function removeBooks (Authors $author): self
    {
        if ($this->authors->contains($author)) {
            $this->authors->removeElement($author);
        }
        return $this;
    }
    public function getCategories(): PersistentCollection
    {
        return $this->categories;
    }
    public function addCategories(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
        return $this;
    }
    public function removeCategories (Categories $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
        return $this;
    }
}
