<?php

class Url {

    public function found_by_short_link($short_link = ''): array |bool
    {
       $data = DbQuery::fetch("SELECT * FROM short_url WHERE `short_url` = ?",[$short_link]);
        if($short_link){
            if(!$data){
                return false;
               }else{
                return $data;
               }
        }
       
    }
    
    public function found_by_full_link($full_link = ''): array |bool
    {
        $data = DbQuery::fetch("SELECT * FROM short_url WHERE `full_url` = ?",[$full_link]);
        
        if ($full_link) {
            if (!$data) {
                return false;
            } else {
                return $data;
            }
        }
    }
    
                    
    public function create_short_link(int $length): string
    {
        $random_bytes = random_bytes(5);
        $hex_link     = bin2hex($random_bytes);
        $hash         = hash('sha256', $hex_link);
    
        $shortLink = substr($hash, 0, $length);
        return $shortLink;
    }
    
    public function get_meaningful_shortlink(string $full_link, null | string $flag = null): string
    {
    
        $host   = parse_url($full_link, PHP_URL_HOST);
        $scheme = parse_url($full_link, PHP_URL_SCHEME);
        if (str_contains($host, 'www')) {
            $domain = explode(".", $host)[1];
        } else {
            $domain = explode(".", $host)[0];
        }
        $deleteVowels = "/(?<=[^aAEeIiUuOoYy])[aAEeIiUuOoYy]?/";
        $noVowelStr   = preg_replace($deleteVowels, "", $domain);
        if ($flag == 'NO_SCHEME') {
            return "{$noVowelStr}";
        } else {
            return "{$scheme}://{$noVowelStr}";
        }
    
    }
    
    public function save_link($short_link = '', $full_link = '')
    {
        if ($short_link && $full_link) {
            if (!$this->found_by_short_link($short_link) && !$this->found_by_full_link($full_link)) {
                $d = date("Y-m-d");
                DbQuery::execute("INSERT INTO short_url (short_url,full_url,date_create,ip_address,s_id) VALUES(?,?,?,?,?)",[$short_link, $full_link, $d, $_SERVER["REMOTE_ADDR"],session_id()]);
            }
        }
    }
    
    
    public function render_full(string $full_link): string
    {
        return "<a href=\"{$full_link}\" target=\"_blank\">{$full_link}</a><br />";
    }
    
    public function render_short(string $full_link, string $visibleLink): string
    {
        return "<a href=\"{$full_link}\" target=\"_blank\">{$visibleLink}</a><br/>";
    }
    
    public function render_redirect(string $short_link_no_scheme){
        return "<a href=\"https://{$_SERVER["SERVER_NAME"]}/go?{$short_link_no_scheme}\" target=\"_blank\">{$short_link_no_scheme}</a><br/>";
    }
    
    public function find_short_links_by_ip(string $ip):array{
      $data = DbQuery::fetchAll("SELECT * FROM short_url WHERE `ip_address` = ?",[$ip]);
      return $data;
    }

    public function find_short_links_by_sid(string $sid):array{
      $data = DbQuery::fetchAll("SELECT * FROM short_url WHERE `s_id` = ?",[$sid]);
      return $data;
    }

}



?>