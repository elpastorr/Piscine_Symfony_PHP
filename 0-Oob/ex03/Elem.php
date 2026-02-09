<?php

class Elem
{
    public $element;
    public string $content;
    public array $res = array();
    public $tags = array("meta", "img", "hr", "br", "html", "head"
                            , "body", "title", "h1", "h2", "h3", "h4"
                            , "h5", "h6", "p", "span", "div");
    public array $prev_contents = array();


    function __construct($element, string $content = "null")
    {
        $this->content = $content;

        $this->element = $element;

        $this->prev_contents[] = $this->content;

        if ($this->find_tag($this->element))
            $this->res[] = array("<$this->element>", "</$this->element>");
        else
            return print "Tag not supported";
    }


    public function pushElement(Elem $elem)
    {
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
        if ($i >= count($this->res))
            return 1;
        $front = $this->res[$i][0];
        $back = $this->res[$i][1];
        $j = $i;
        while ($j-- > 0)
            fwrite($file, "\t");
        fwrite($file, "$front\n");

        $tmp = $this->prev_contents[$i];
        if ($tmp != "null")
        {
            $j = $i;
            while($j > 0)
            {
                fwrite($file, "\t");
                $j--;
            }
            fwrite($file, "$tmp\n");
        }

        $this->recursive_helper($file, ++$i);
        $j = 0;
        while ($j++ < $i - 1)
            fwrite($file, "\t");
        fwrite($file, "$back\n");
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
}