<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationsRepository")
 */
class Reservations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    private $reservationDate;
    public function __construct()
    {
        $this->reservationDate = new \DateTime();
    }

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Attention le format date jj/mm/aaaa est requis")
     */
    private $loanDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Attention le format date jj/mm/aaaa est requis")
     */
    private $returnDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Attention le format date jj/mm/aaaa est requis")
     */
    private $availabilityDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnComment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="reservation")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prospects", inversedBy="reservation")
     */
    private $prospect;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="reservation")
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $realReturnDate;

    private $viewDate;

    /**
     * verify if loan date is available
     */
    public function isAvailableDate()
    { // 1) il faut connaitre les dates impossibles pour la réservation de notre article
        $notAvailableDays = $this->article->getNotAvailableDays();//function de l'entité Articles

        // 2) il faut comparer les dates choisies avec les dates impossibles
        $reservationDays = $this->getDays();

        // 3 on transforme les secondes du "getDays" en jours qu'on insère dans un array
        $formatDay = function ($day){
            return $day->format('Y-m-d');
        };

        $days = array_map($formatDay, $reservationDays);

        // 4 pareil pour le getNotAvailableDays
        $notAvailable = array_map($formatDay, $notAvailableDays);

        // 5 on compare les deux tableaux
        foreach ($days as $day) {
            if (array_search($day, $notAvailable) !== false) return false;
        }
        return true;
    }

    /**
     * Permet de récupérer un tableau des journées qui correspondent à ma réservation
     * @return array
     * Un tableau d'objet Datetime représentant les jours de la réservation
     */
    public function getDays(){
        // 1 on récupère toutes les secondes entre les deux dates
        $result = range(
            $this->loanDate->getTimestamp(),
            $this->returnDate->getTimestamp(),
            24 * 60 * 60
        );
        // 2 on transforme ces secondes en jours qu'on insère dans un array
        $days = array_map(function($dayTimestamp){
            return new \DateTime(date('Y-m-d', $dayTimestamp));
        }, $result);

        return $days;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(?\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getLoanDate(): ?\DateTimeInterface
    {
        return $this->loanDate;
    }

    public function setLoanDate(?\DateTimeInterface $loanDate): self
    {
        $this->loanDate = $loanDate;

        return $this;
    }

    public function getViewDate(){
        return$this->loanDate;
    }

    public function setViewDate(?\DateTimeInterface $loanDate, $viewDate)
    {
        $viewDate->loanDate = $loanDate;

        return $viewDate;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getAvailabilityDate(): ?\DateTimeInterface
    {
        return $this->availabilityDate;
    }

    public function setAvailabilityDate(?\DateTimeInterface $availabilityDate): self
    {
        $this->availabilityDate = $availabilityDate;

        return $this;
    }

    public function getReturnComment(): ?string
    {
        return $this->returnComment;
    }

    public function setReturnComment(string $returnComment): self
    {
        $this->returnComment = $returnComment;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->article;
    }

    public function setArticle(?Articles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getProspect(): ?Prospects
    {
        return $this->prospect;
    }

    public function setProspect(?Prospects $prospect): self
    {
        $this->prospect = $prospect;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRealReturnDate(): ?\DateTimeInterface
    {
        return $this->realReturnDate;
    }

    public function setRealReturnDate(?\DateTimeInterface $realReturnDate): self
    {
        $this->realReturnDate = $realReturnDate;

        return $this;
    }

}
