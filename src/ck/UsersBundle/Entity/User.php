<?php
namespace ck\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use ck\RecipesBundle\Entity\Recipe as Recipe;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="ck\RecipesBundle\Entity\Recipe", inversedBy="users")
     * @ORM\JoinTable(name="bind_users_favorite_recipes",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="recipe_id", referencedColumnName="id")}
     *      )
     */
    protected $favoriteRecipes;

    public function __construct()
    {
        parent::__construct();

        $this->$favoriteRecipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add favoriteRecipe
     *
     * @param Recipe $recipe
     * @return User
     */
    public function addFavoriteRecipe(Recipe $recipe)
    {
        $this->favoriteRecipes[] = $recipe;
    
        return $this;
    }

    /**
     * Remove favoriteRecipe
     *
     * @param Recipe $recipe
     */
    public function removeFavoriteRecipe(Recipe $recipe)
    {
        $this->favoriteRecipes->removeElement($recipe);
    }

    /**
     * Get favoriteRecipe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavoriteRecipes()
    {
        return $this->favoriteRecipes;
    }
}