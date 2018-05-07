<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volunteer
 *
 * @ORM\Table(name="volunteer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VolunteerRepository")
 */
class Volunteer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="organization", type="string", length=255)
     */
    private $organization;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=510)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=255)
     */
    private $cause;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finish", type="datetime")
     */
    private $finish;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=25500)
     */
    private $description;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set organization.
     *
     * @param string $organization
     *
     * @return Volunteer
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization.
     *
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set role.
     *
     * @param string $role
     *
     * @return Volunteer
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set cause.
     *
     * @param string $cause
     *
     * @return Volunteer
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause.
     *
     * @return string
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set start.
     *
     * @param \DateTime $start
     *
     * @return Volunteer
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set finish.
     *
     * @param \DateTime $finish
     *
     * @return Volunteer
     */
    public function setFinish($finish)
    {
        $this->finish = $finish;

        return $this;
    }

    /**
     * Get finish.
     *
     * @return \DateTime
     */
    public function getFinish()
    {
        return $this->finish;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Volunteer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
