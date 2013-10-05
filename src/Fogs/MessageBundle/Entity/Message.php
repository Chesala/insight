<?php


namespace Fogs\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\MessageBundle\Entity\Message as BaseMessage;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\MessageMetadata as ModelMessageMetadata;

/**
 * @ORM\Entity
 */
class Message extends BaseMessage
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Fogs\MessageBundle\Entity\Thread", inversedBy="messages")
	 * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
	 */
	protected $thread;

	/**
	 * @ORM\ManyToOne(targetEntity="Fogs\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $sender;

	/**
	 * @ORM\OneToMany(targetEntity="Fogs\MessageBundle\Entity\MessageMetadata", mappedBy="message", cascade={"all"})
	 */
	protected $metadata;

	public function __construct()
	{
		parent::__construct();

		$this->metadata  = new ArrayCollection();
	}

	public function setThread(ThreadInterface $thread) {
		$this->thread = $thread;
		return $this;
	}

	public function setSender(ParticipantInterface $sender) {
		$this->sender = $sender;
		return $this;
	}

	public function addMetadata(ModelMessageMetadata $meta) {
		$meta->setMessage($this);
		parent::addMetadata($meta);
	}

}