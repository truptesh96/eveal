<?php

/**
 * Connection between Squirrly and Quick Squirrly SEO Table
 * Class SQ_Models_Qss
 */
class SQ_Models_Qss {


    /**
     * Get the post data by hash
     * @param null $hash
     * @return stdClass
     */
    public function getSqPost($hash = null) {
        global $wpdb;

        $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post');

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            if ($row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . _SQ_DB_ . "` WHERE blog_id = %d AND url_hash = %s", (int)$blog_id, $hash), OBJECT)) {
                $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post', maybe_unserialize($row->post));
                $post->url = $row->URL; //set the URL for this post
            }
        }

        return $post;
    }

    /**
     * Get the Sq for a specific Post from database
     * @param string $hash
     * @return mixed|null
     */
    public function getSqSeo($hash = null) {
        global $wpdb;

        $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq');

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            if ($row = $wpdb->get_row($wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . _SQ_DB_ . "` WHERE blog_id = %d AND url_hash = %s", (int)$blog_id, $hash), OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        }

        return $metas;
    }

    /**
     * Save the SEO for a specific Post into database
     * @param $url
     * @param $url_hash
     * @param $post
     * @param $seo
     * @param $date_time
     * @return false|int
     */
    public function saveSqSEO($url, $url_hash, $post, $seo, $date_time) {
        global $wpdb;
        $wpdb->hide_errors();

        $blog_id = get_current_blog_id();

        $result = $wpdb->query($wpdb->prepare("INSERT INTO `" . $wpdb->prefix . _SQ_DB_ . "` 
                (blog_id, URL, url_hash, post, seo, date_time)
                VALUES (%d,%s,%s,%s,%s,%s)  ON DUPLICATE KEY
                UPDATE blog_id = %d, URL = %s, url_hash = %s, post = %s, seo = %s, date_time = %s"
            , $blog_id, $url, $url_hash, $post, $seo, $date_time, $blog_id, $url, $url_hash, $post, $seo, $date_time));

        $wpdb->show_errors();

        return $result;
    }

    /**
     * Get the saved Permalink for a specific Post from database
     * @param string $hash
     * @return mixed|null
     */
    public function getPermalink($hash = null) {
        global $wpdb;
        $url = false;

        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            if ($row = $wpdb->get_row($wpdb->prepare("SELECT URL FROM `" . $wpdb->prefix . _SQ_DB_ . "` WHERE blog_id = %d AND url_hash = %s", (int)$blog_id, $hash), OBJECT)) {
                $url = $row->URL;
            }

        }

        return $url;
    }

    /**
     * Check if the table exists
     */
    public function checkTableExists() {
        global $wpdb;

        $wpdb->hide_errors();
        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->prefix . _SQ_DB_);

        if ($wpdb->get_var($query) === $wpdb->prefix . _SQ_DB_) {
            $this->alterTable();
        }else {
            $this->createTable();
        }
    }

    /**
     * Create DB Table
     */
    public static function createTable() {
        global $wpdb;
        $collate = $wpdb->get_charset_collate();
        $sq_table_query = 'CREATE TABLE ' . $wpdb->prefix . _SQ_DB_ . ' (
                      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `blog_id` INT(10) NOT NULL,
                      `post` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `URL` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `url_hash` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `seo` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                      `date_time` DATETIME NOT NULL,
                      PRIMARY KEY(id),
                      UNIQUE url_hash(url_hash) USING BTREE,
                      INDEX blog_id_url_hash(blog_id, url_hash) USING BTREE
                      )  ' . $collate;

        try {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            if (function_exists('dbDelta')) {
                dbDelta($sq_table_query);
            }
        } catch (Exception $e) {
        }

    }

    public static function alterTable() {
        global $wpdb;
        $wpdb->hide_errors();

        if (file_exists(ABSPATH . 'wp-admin/includes/upgrade.php')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $count = $wpdb->get_row($wpdb->prepare("SELECT count(*) as count
                              FROM information_schema.columns
                              WHERE table_name = '" . $wpdb->prefix . _SQ_DB_ . "'
                              AND column_name = %s", 'post'));

            if ($count->count == 0) {
                $wpdb->query("ALTER TABLE `" . $wpdb->prefix . _SQ_DB_ . "` ADD COLUMN post VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");
            }

        }
        $wpdb->show_errors();

    }


}