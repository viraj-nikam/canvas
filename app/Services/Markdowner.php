<?php

namespace App\Services;

use Michelf\SmartyPants;
use Michelf\MarkdownExtra;

class Markdowner
{
  /**
   * Transform raw text to markdown.
   *
   * @return $text
   */
  public function toHTML($text)
  {
    $text = $this->preTransformText($text);
    $text = MarkdownExtra::defaultTransform($text);
    $text = SmartyPants::defaultTransform($text);
    $text = $this->postTransformText($text);
    return $text;
  }

  protected function preTransformText($text)
  {
    return $text;
  }

  protected function postTransformText($text)
  {
    return $text;
  }
}
