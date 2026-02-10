<?php

include "MyException.php";

class Elem
{
    public $element;
    public string $content;
    public array $res = array();
    public array $attributes;
    public string $attribute_str = "";
    public $tags = array("meta", "img", "hr", "br", "html", "head"
                        , "body", "title", "h1", "h2", "h3", "h4"
                        , "h5", "h6", "p", "span", "div", "table"
                        , "tr", "th", "td", "ul", "ol", "li");
    public array $prev_contents = array();

    public array $children = [];

    function __construct($element, string $content = "null", array $attributes = [])
    {
        $this->content = $content;

        $this->element = $element;

        $this->attributes = $attributes;
        if ($attributes)
            $this->attributes_to_str();

        $this->prev_contents[] = $this->content;

        if ($this->find_tag($this->element))
        {
            if ($attributes)
                $this->res[] = array("<$this->element" . " $this->attribute_str>", "</$this->element>");
            else
                $this->res[] = array("<$this->element>", "</$this->element>");
        }
        else
            throw new MyException("Tag not supported: $element");
    }


    public function attributes_to_str()
    {
        foreach ($this->attributes as $attribute)
        {
            $tmp = key($this->attributes) . '=' . '"' . current($this->attributes) . '"';
            $this->attribute_str = $tmp;
        }
    }


    public function pushElement(Elem $elem)
    {
        $this->children[] = $elem;
        $i = 0;
        if ($elem->content != null)
        {
            foreach($elem->prev_contents as $contents)
                $this->prev_contents[] = $contents;
        }
        foreach ($elem->res as $tag)
        {
            $this->res[] = array($elem->res[$i][0], $elem->res[$i][1]);
            $i++;
        }
    }
    

    public function getHTML()
    {
        $i = 0;
        $file = fopen("result.html", "w");
        $this->recursive_helper($file, $i);
        fclose($file);
    }


    public function recursive_helper($file, $i)
    {
        // echo "i: $i\n";
        // echo "res: " . $this->res[0][0] . "\n";
        $indent = str_repeat("\t", $i);

        fwrite($file, $indent . $this->res[0][0] . "\n");

        foreach ($this->children as $child)
            $child->recursive_helper($file, $i + 1);

        if ($this->content != "null")
            fwrite($file, $indent . "\t" . "$this->content\n");

        fwrite($file, $indent . $this->res[0][1] . "\n");
        return 0;
    }


    public function find_tag(string $elem)
    {
        foreach ($this->tags as $tag)
        {
            if ($tag == $elem)
                return 1;
        }
        return 0;
    }


    public function validPage(): bool
    {
        if ($this->element !== "html")
            return false;

        if (count($this->children) !== 2)
            return false;
        if ($this->children[0]->element !== "head" || $this->children[1]->element !== "body")
            return false;

        if (!$this->checkHead($this->children[0]))
            return false;

        return $this->recursive_validate($this);
    }


    private function checkHead(Elem $head): bool
    {
        $nb_title = 0;
        $nb_meta_charset = 0;
        foreach ($head->children as $child) {
            if ($child->element === "title")
                $nb_title++;
            if ($child->element === "meta" && isset($child->attributes["charset"]))
                $nb_meta_charset++;
        }
        return $nb_title === 1 && $nb_meta_charset === 1;
    }


    private function recursive_validate(Elem $node): bool
    {
        if ($node->element === "p" && count($node->children) > 0)
            return false;

        if ($node->element === "table") {
            foreach($node->children as $child) {
                if ($child->element !== "tr")
                    return false;
            }
        }

        if ($node->element === "tr") {
            foreach($node->children as $child) {
                if ($child->element !== "th" && $child->element !== "td")
                    return false;
            }
        }

        if ($node->element === "ul" || $node->element === "ol") {
            foreach($node->children as $child) {
                if ($child->element !== "li")
                    return false;
            }
        }

        foreach ($node->children as $child) {
            if (!$this->recursive_validate($child))
                return false;
        }
        return true;
    }
}