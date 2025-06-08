<?php
    session_start();
    include ("./config/config.php");
    include ("save.php");

    $input_string = $_POST['input_box'];


    $input = isset($_POST['mode']) ? "" : simplexml_load_string($input_string);



    function xml_to_emmet($xml) 
    {
        $emmet = '';
        $root_tag = $xml->getName();
        $value = trim((string)$xml);
        $emmet .= $root_tag;
        $attributes = $xml->attributes();

        if ($attributes) 
        {
            if(isset($_POST['attributes']) || isset($_POST['attributes_val'])) 
            {
                foreach ($attributes as $attrName => $attrValue) 
                {
                    $emmet .= '.' . $attrName;
                    if(isset($_POST['attributes_val']))
                        $emmet .= '{' . $attrValue . '}';
                }
            }
        }

        if ($value !== '' && isset($_POST['text']))
            $emmet .=  '{' . $value . '}';

        $children = $xml->children();
        $groups = array();
        if (count($children) > 0) 
        {
            $emmet = '(' . $emmet;
            foreach ($children as $child) 
                $groups[] = xml_to_emmet($child);

            $emmet .=  '>' . implode('+', $groups) . ')';
        }

        return $emmet;
    }


    function emmet_to_xml($emmet)
    {
        $output = "";

        $tags = [[]];
        $currentTag = "";

        $currentGroup = 0;
        $groupCount = [];
        $groupCount[0] = 0;
        $wasGrouped = false;

        $attributes = "";
        $textValue = "";

        $currentLevel = 1;

        $length = strlen($emmet);

        for ($i = 0; $i < $length; $i++) 
        {
            $char = $emmet[$i];

            if ($char === ">") 
            {
                if ($wasGrouped)
                {
                    $wasGrouped = false;
                    continue;
                }
                $groupCount[$currentGroup]++;
                $tags[$currentGroup][$currentLevel - 1] = $currentTag;

                $output .= "\n" . str_repeat("\t", $currentLevel) . "<" . $currentTag . $attributes . ">" . $textValue;

                $currentTag = "";
                $attributes = "";
                $textValue = "";
                $currentLevel++;
            }
            else if ($char === "+") 
            {
                if ($wasGrouped)
                {
                    $wasGrouped = false;
                    continue;
                }

                $tags[$currentGroup][$currentLevel - 1] = $currentTag;
                $output .= "\n" . str_repeat("\t", $currentLevel) . "<" . $tags[$currentGroup][$currentLevel - 1] . $attributes . ">" . $textValue . "</" . $tags[$currentGroup][$currentLevel - 1] . ">";

                $currentTag = "";
                $attributes = "";
                $textValue = "";
            }
            else if ($char === "^") 
            {
                if ($currentTag === "")
                {
                    $currentLevel--;
                    $output .= "\n" . str_repeat("\t", $currentLevel) . "</" . $tags[$currentGroup][$currentLevel - 1] . ">";
                }
                else
                {
                    $tags[$currentGroup][$currentLevel - 1] = $currentTag;
                    $output .= "\n" . str_repeat("\t", $currentLevel) . "<" . $tags[$currentGroup][$currentLevel - 1] . $attributes . ">" . $textValue . "</" . $tags[$currentGroup][$currentLevel - 1] . ">";

                    $currentLevel--;

                    $output .= "\n" . str_repeat("\t", $currentLevel) . "</" . $tags[$currentGroup][$currentLevel - 1] . ">";

                    $currentTag = "";
                    $attributes = "";
                    $textValue = "";
                }
            }
            else if ($char === "{")
            {
                if (!isset($_POST["element_val"]))
                {
                    $i++;
                    $char = $emmet[$i];
                    while ($char !== "}")
                    {
                        $i++;
                        $char = $emmet[$i];
                    }
                }
                else
                {
                    $i++;
                    $char = $emmet[$i];
                    while ($char !== "}")
                    {
                        $textValue .= $char;
                        $i++;
                        $char = $emmet[$i];
                    }
                }
            }
            else if ($char === "(")
            {
                $currentGroup++;
                $groupCount[$currentGroup] = 1;

                if ($currentGroup >= count($tags))
                {
                    $tags[] = [];
                }
            }
            else if ($char === ")")
            {
                $output .= "\n" . str_repeat("\t", $currentLevel) . "<" . $currentTag . $attributes . ">" . $textValue . "</" . $currentTag . ">";
                for ($j = 0; $j < $groupCount[$currentGroup] - 1; $j++)
                {
                    $currentLevel--;
                    $output .= "\n" . str_repeat("\t", $currentLevel) . "</" . $tags[$currentGroup][$currentLevel - 1] . ">";
                }
                $currentGroup--;

                $currentTag = "";
                $attributes = "";
                $textValue = "";

                $wasGrouped = true;
            }
            else if ($char === "[")
            {
                if (!isset($_POST['attributes']))
                {
                    $i++;
                    $char = $emmet[$i];
                    while ($char !== "]")
                    {
                        $i++;
                        $char = $emmet[$i];
                    }
                }
                else 
                {
                    $hasValue = false;
                    $inString = false;

                    $i++;
                    $char = $emmet[$i];
                    while ($char !== "]")
                    {
                        if ($char === "\"" && !$inString) $inString = true;
                        else if ($char === "\"" && $inString) $inString = false;

                        if ($char === "=")
                        {
                            if (!isset($_POST['attributes_val']))
                            {
                                $cnt = 0;
                                while ($cnt != 2)
                                {
                                    $i++;
                                    $char = $emmet[$i];
                                    if ($char === "\"") $cnt++;
                                }
                            }
                            else
                            {
                                $hasValue = true;
                                $attributes .= $char;
                            }
                        }
                        else if ($hasValue && $char === " " && !$inString)
                        {
                            $hasValue = false;
                            $attributes .= " ";
                        }
                        else if (!$hasValue && $char === " " && !$inString && isset($_POST['attributes_val']))
                        {
                            $attributes .= ' ';
                        }
                        else if (!$hasValue && isset($emmet[$i + 1]) && $emmet[$i + 1] === "]" && isset($_POST['attributes_val']))
                        {
                            $attributes .= $char;
                        }
                        else
                        {
                            $attributes .= $char;
                        }

                        $i++;
                        $char = $emmet[$i];
                    }
                    $attributes = " " . $attributes;
                }
            }
            else
            {
                $currentTag .= $char;
            }
        }

        $tags[$currentGroup][$currentLevel - 1] = $currentTag;
        if ($currentTag !== "") $output .= "\n" . str_repeat("\t", $currentLevel) . "<" . $currentTag . $attributes . ">" . $textValue;

        if ($emmet[$length - 1] === ")")
        {
            $output .= "\n" . str_repeat("\t", $currentLevel - 1);
        }
        while ($currentLevel > 0)
        {
            if (isset($tags[$currentGroup][$currentLevel - 1]) && $tags[$currentGroup][$currentLevel - 1] !== "")
            {
                $output .= "</" . $tags[$currentGroup][$currentLevel - 1] . ">\n" . str_repeat("\t", $currentLevel - 1);
            }
            $currentLevel--;
        }


        return $output;
    }



    $output = isset($_POST['mode']) ? emmet_to_xml($input_string) : xml_to_emmet($input);
    $_SESSION['last_input'] = $input_string;
    $_SESSION['last_output'] = htmlspecialchars($output);
    save(isset($_POST['mode']) ? 2 : 1,$input_string, $output, $_SESSION['id']);
?>
