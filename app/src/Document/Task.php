<?php
// src/Document/Task.php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Task
{
    /**
     * @ODM\Id(strategy="INCREMENT")
     */
    protected $id;

    /** @ODM\Field(type="string") */
    protected string $desc;

	/**
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}

	/**
	 * 
	 * @return string
	 */
	public function getDesc(): string {
		return $this->desc;
	}

	/**
	 * 
	 * @param string $desc 
	 * @return self
	 */
	public function setDesc(string $desc): self {
		$this->desc = $desc;
		return $this;
	}
}