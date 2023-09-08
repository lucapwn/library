<?php
    // Evite SQL Injection ;)

    function protect(&$text) {
        if (!is_array($text)) {                      
            $text = preg_replace("/(from|select|insert|delete|where|drop|union|order|update|database)/i", "", $text);
            $table = get_html_translation_table(HTML_ENTITIES);
            $table = array_flip($table);
            $text = addslashes($text);
            $text = strip_tags($text);
            return strtr($text, $table);
        }

        return array_filter($text, "protect");
    }
?>