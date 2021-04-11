-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2021 at 11:54 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eveal`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'A WordPress Commenter', 'wapuu@wordpress.example', 'https://wordpress.org/', '', '2021-04-05 13:24:05', '2021-04-05 13:24:05', 'Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href=\"https://gravatar.com\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://localhost/eveal', 'yes'),
(2, 'home', 'http://localhost/eveal', 'yes'),
(3, 'blogname', 'eveal', 'yes'),
(4, 'blogdescription', 'Digital Agency', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'patel.truptesh1996@gmail.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '0', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:95:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:38:\"index.php?&page_id=7&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:3:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;s:36:\"contact-form-7/wp-contact-form-7.php\";i:2;s:49:\"duplicate-wp-page-post/duplicate-wp-page-post.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'eve', 'yes'),
(41, 'stylesheet', 'eve', 'yes'),
(42, 'comment_registration', '0', 'yes'),
(43, 'html_type', 'text/html', 'yes'),
(44, 'use_trackback', '0', 'yes'),
(45, 'default_role', 'subscriber', 'yes'),
(46, 'db_version', '49752', 'yes'),
(47, 'uploads_use_yearmonth_folders', '1', 'yes'),
(48, 'upload_path', '', 'yes'),
(49, 'blog_public', '0', 'yes'),
(50, 'default_link_category', '2', 'yes'),
(51, 'show_on_front', 'page', 'yes'),
(52, 'tag_base', '', 'yes'),
(53, 'show_avatars', '1', 'yes'),
(54, 'avatar_rating', 'G', 'yes'),
(55, 'upload_url_path', '', 'yes'),
(56, 'thumbnail_size_w', '150', 'yes'),
(57, 'thumbnail_size_h', '150', 'yes'),
(58, 'thumbnail_crop', '1', 'yes'),
(59, 'medium_size_w', '300', 'yes'),
(60, 'medium_size_h', '300', 'yes'),
(61, 'avatar_default', 'mystery', 'yes'),
(62, 'large_size_w', '1024', 'yes'),
(63, 'large_size_h', '1024', 'yes'),
(64, 'image_default_link_type', 'none', 'yes'),
(65, 'image_default_size', '', 'yes'),
(66, 'image_default_align', '', 'yes'),
(67, 'close_comments_for_old_posts', '0', 'yes'),
(68, 'close_comments_days_old', '14', 'yes'),
(69, 'thread_comments', '1', 'yes'),
(70, 'thread_comments_depth', '5', 'yes'),
(71, 'page_comments', '0', 'yes'),
(72, 'comments_per_page', '50', 'yes'),
(73, 'default_comments_page', 'newest', 'yes'),
(74, 'comment_order', 'asc', 'yes'),
(75, 'sticky_posts', 'a:0:{}', 'yes'),
(76, 'widget_categories', 'a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(77, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(78, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(79, 'uninstall_plugins', 'a:0:{}', 'no'),
(80, 'timezone_string', '', 'yes'),
(81, 'page_for_posts', '0', 'yes'),
(82, 'page_on_front', '7', 'yes'),
(83, 'default_post_format', '0', 'yes'),
(84, 'link_manager_enabled', '0', 'yes'),
(85, 'finished_splitting_shared_terms', '1', 'yes'),
(86, 'site_icon', '58', 'yes'),
(87, 'medium_large_size_w', '768', 'yes'),
(88, 'medium_large_size_h', '0', 'yes'),
(89, 'wp_page_for_privacy_policy', '3', 'yes'),
(90, 'show_comments_cookies_opt_in', '1', 'yes'),
(91, 'admin_email_lifespan', '1633181045', 'yes'),
(92, 'disallowed_keys', '', 'no'),
(93, 'comment_previously_approved', '1', 'yes'),
(94, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
(95, 'auto_update_core_dev', 'enabled', 'yes'),
(96, 'auto_update_core_minor', 'enabled', 'yes'),
(97, 'auto_update_core_major', 'enabled', 'yes'),
(98, 'initial_db_version', '49752', 'yes'),
(99, 'wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(100, 'fresh_site', '0', 'yes'),
(101, 'widget_search', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(102, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(104, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(105, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'sidebars_widgets', 'a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}', 'yes'),
(107, 'cron', 'a:6:{i:1618136645;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1618147445;a:5:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:18:\"wp_https_detection\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1618147566;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1618147568;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1618320245;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(108, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(113, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(114, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(115, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(116, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(118, 'recovery_keys', 'a:0:{}', 'yes'),
(119, 'theme_mods_twentytwentyone', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1617629830;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";}s:9:\"sidebar-2\";a:3:{i:0;s:10:\"archives-2\";i:1;s:12:\"categories-2\";i:2;s:6:\"meta-2\";}}}}', 'yes'),
(120, 'https_detection_errors', 'a:1:{s:23:\"ssl_verification_failed\";a:1:{i:0;s:24:\"SSL verification failed.\";}}', 'yes'),
(121, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.7.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.7.zip\";s:10:\"no_content\";s:68:\"https://downloads.wordpress.org/release/wordpress-5.7-no-content.zip\";s:11:\"new_bundled\";s:69:\"https://downloads.wordpress.org/release/wordpress-5.7-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:3:\"5.7\";s:7:\"version\";s:3:\"5.7\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.6\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1618116714;s:15:\"version_checked\";s:3:\"5.7\";s:12:\"translations\";a:0:{}}', 'no'),
(127, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1618116715;s:7:\"checked\";a:2:{s:3:\"eve\";s:5:\"1.0.0\";s:14:\"twentynineteen\";s:3:\"2.0\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:1:{s:14:\"twentynineteen\";a:6:{s:5:\"theme\";s:14:\"twentynineteen\";s:11:\"new_version\";s:3:\"2.0\";s:3:\"url\";s:44:\"https://wordpress.org/themes/twentynineteen/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/twentynineteen.2.0.zip\";s:8:\"requires\";s:5:\"4.9.6\";s:12:\"requires_php\";s:5:\"5.2.4\";}}s:12:\"translations\";a:0:{}}', 'no'),
(128, '_site_transient_timeout_browser_83f75fe8d5c2f40c243760c04f60cc4e', '1618233967', 'no'),
(129, '_site_transient_browser_83f75fe8d5c2f40c243760c04f60cc4e', 'a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:13:\"89.0.4389.114\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}', 'no'),
(130, '_site_transient_timeout_php_check_7841c854be39099ac1d9b61bb411ecb0', '1618233968', 'no'),
(131, '_site_transient_php_check_7841c854be39099ac1d9b61bb411ecb0', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"5.6.20\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'no'),
(133, 'can_compress_scripts', '1', 'no'),
(151, 'finished_updating_comment_type', '1', 'yes'),
(152, 'current_theme', 'Eveal', 'yes'),
(153, 'theme_mods_twentynineteen', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1617629844;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(154, 'theme_switched', '', 'yes'),
(156, 'theme_mods_eve', 'a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:1:{s:6:\"menu-1\";i:8;}s:18:\"custom_css_post_id\";i:-1;s:11:\"custom_logo\";i:56;}', 'yes'),
(160, 'recently_activated', 'a:0:{}', 'yes'),
(163, 'acf_version', '5.9.5', 'yes'),
(164, 'dpp_wpp_page_options', 'a:5:{s:15:\"dpp_post_status\";s:5:\"draft\";s:17:\"dpp_post_redirect\";s:7:\"to_list\";s:15:\"dpp_post_suffix\";s:0:\"\";s:14:\"dpp_posteditor\";s:7:\"classic\";s:19:\"dpp_post_link_title\";s:0:\"\";}', 'yes'),
(187, '_transient_health-check-site-status-result', '{\"good\":15,\"recommended\":4,\"critical\":1}', 'yes'),
(197, 'category_children', 'a:0:{}', 'yes'),
(216, '_transient_timeout_acf_plugin_updates', '1618218645', 'no'),
(217, '_transient_acf_plugin_updates', 'a:4:{s:7:\"plugins\";a:0:{}s:10:\"expiration\";i:172800;s:6:\"status\";i:1;s:7:\"checked\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";s:5:\"5.9.5\";}}', 'no'),
(223, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1618116715;s:7:\"checked\";a:5:{s:34:\"advanced-custom-fields-pro/acf.php\";s:5:\"5.9.5\";s:19:\"akismet/akismet.php\";s:5:\"4.1.9\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:3:\"5.4\";s:49:\"duplicate-wp-page-post/duplicate-wp-page-post.php\";s:5:\"2.6.4\";s:9:\"hello.php\";s:5:\"1.7.2\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:4:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.1.9\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.1.9.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}}s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:3:\"5.4\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/contact-form-7.5.4.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:67:\"https://ps.w.org/contact-form-7/assets/icon-256x256.png?rev=2279696\";s:2:\"1x\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";s:3:\"svg\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}}s:49:\"duplicate-wp-page-post/duplicate-wp-page-post.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:36:\"w.org/plugins/duplicate-wp-page-post\";s:4:\"slug\";s:22:\"duplicate-wp-page-post\";s:6:\"plugin\";s:49:\"duplicate-wp-page-post/duplicate-wp-page-post.php\";s:11:\"new_version\";s:5:\"2.6.4\";s:3:\"url\";s:53:\"https://wordpress.org/plugins/duplicate-wp-page-post/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/duplicate-wp-page-post.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:75:\"https://ps.w.org/duplicate-wp-page-post/assets/icon-128x128.png?rev=1572300\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:77:\"https://ps.w.org/duplicate-wp-page-post/assets/banner-772x250.png?rev=1572325\";}s:11:\"banners_rtl\";a:0:{}}s:9:\"hello.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}}}}', 'no'),
(224, 'wpcf7', 'a:2:{s:7:\"version\";s:3:\"5.4\";s:13:\"bulk_validate\";a:4:{s:9:\"timestamp\";i:1618045931;s:7:\"version\";s:3:\"5.4\";s:11:\"count_valid\";i:1;s:13:\"count_invalid\";i:0;}}', 'yes'),
(225, 'options_footer_script', '', 'no'),
(226, '_options_footer_script', 'field_60716c322024b', 'no'),
(227, 'options_copyright_text', '© CodePlus Technologies | All rights reserved', 'no'),
(228, '_options_copyright_text', 'field_60716c62b87db', 'no'),
(230, 'secret_key', 'p:W5[SJ-`Hq+t,=^Fj-#K{t#Lz?J/o^@-kpc&*@,bOr:Vi(sFLi;)<|.x<#K%YI:', 'no'),
(234, 'nav_menu_options', 'a:1:{s:8:\"auto_add\";a:0:{}}', 'yes'),
(250, 'options_error_text', 'The Page Not Found...!', 'no'),
(251, '_options_error_text', 'field_6072aaf969792', 'no'),
(252, 'options_error_page_quick_links_0_quick_link', 'a:3:{s:5:\"title\";s:4:\"Home\";s:3:\"url\";s:23:\"http://localhost/eveal/\";s:6:\"target\";s:0:\"\";}', 'no'),
(253, '_options_error_page_quick_links_0_quick_link', 'field_6072ab4869794', 'no'),
(254, 'options_error_page_quick_links_1_quick_link', 'a:3:{s:5:\"title\";s:5:\"About\";s:3:\"url\";s:29:\"http://localhost/eveal/about/\";s:6:\"target\";s:0:\"\";}', 'no'),
(255, '_options_error_page_quick_links_1_quick_link', 'field_6072ab4869794', 'no'),
(256, 'options_error_page_quick_links_2_quick_link', 'a:3:{s:5:\"title\";s:12:\"Get In Touch\";s:3:\"url\";s:34:\"http://localhost/eveal/contact-us/\";s:6:\"target\";s:0:\"\";}', 'no'),
(257, '_options_error_page_quick_links_2_quick_link', 'field_6072ab4869794', 'no'),
(258, 'options_error_page_quick_links_3_quick_link', 'a:3:{s:5:\"title\";s:10:\"Post Item3\";s:3:\"url\";s:45:\"http://localhost/eveal/2021/04/08/post-item3/\";s:6:\"target\";s:0:\"\";}', 'no'),
(259, '_options_error_page_quick_links_3_quick_link', 'field_6072ab4869794', 'no'),
(260, 'options_error_page_quick_links', '4', 'no'),
(261, '_options_error_page_quick_links', 'field_6072ab2a69793', 'no'),
(263, '_site_transient_timeout_theme_roots', '1618132844', 'no'),
(264, '_site_transient_theme_roots', 'a:2:{s:3:\"eve\";s:7:\"/themes\";s:14:\"twentynineteen\";s:7:\"/themes\";}', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(8, 7, '_edit_lock', '1618133294:1'),
(9, 9, '_edit_lock', '1617882929:1'),
(12, 12, '_edit_last', '1'),
(13, 12, '_edit_lock', '1618121519:1'),
(14, 22, '_wp_attached_file', '2021/04/banner.jpg'),
(15, 22, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:4:\"file\";s:18:\"2021/04/banner.jpg\";s:5:\"sizes\";a:5:{s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"banner-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:19:\"banner-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"banner-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:18:\"banner-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:19:\"banner-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(16, 7, '_edit_last', '1'),
(17, 7, 'banner_slides_0_banner_background', 'image'),
(18, 7, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(19, 7, 'banner_slides_0_slide_title', 'Banner Slide1'),
(20, 7, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(21, 7, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(22, 7, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(23, 7, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(24, 7, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(25, 7, 'banner_slides_0_slide_ctas', '1'),
(26, 7, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(27, 7, 'banner_slides_0_slide_image', '22'),
(28, 7, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(29, 7, 'banner_slides', '2'),
(30, 7, '_banner_slides', 'field_606b1df75a8cf'),
(31, 23, 'banner_slides_0_banner_background', 'image'),
(32, 23, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(33, 23, 'banner_slides_0_slide_title', 'Banner S;ide1'),
(34, 23, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(35, 23, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(36, 23, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(37, 23, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(38, 23, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(39, 23, 'banner_slides_0_slide_ctas', '1'),
(40, 23, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(41, 23, 'banner_slides_0_slide_image', '22'),
(42, 23, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(43, 23, 'banner_slides', '1'),
(44, 23, '_banner_slides', 'field_606b1df75a8cf'),
(45, 7, 'banner_slides_1_banner_background', 'video'),
(46, 7, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(47, 7, 'banner_slides_1_slide_title', 'Banner Slide2'),
(48, 7, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(49, 7, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(50, 7, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(51, 7, 'banner_slides_1_slide_ctas', '1'),
(52, 7, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(53, 7, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(54, 7, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(55, 24, 'banner_slides_0_banner_background', 'image'),
(56, 24, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(57, 24, 'banner_slides_0_slide_title', 'Banner Slide1'),
(58, 24, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(59, 24, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(60, 24, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(61, 24, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(62, 24, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(63, 24, 'banner_slides_0_slide_ctas', '1'),
(64, 24, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(65, 24, 'banner_slides_0_slide_image', '22'),
(66, 24, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(67, 24, 'banner_slides', '2'),
(68, 24, '_banner_slides', 'field_606b1df75a8cf'),
(69, 24, 'banner_slides_1_banner_background', 'video'),
(70, 24, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(71, 24, 'banner_slides_1_slide_title', 'Banner Slide2'),
(72, 24, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(73, 24, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(74, 24, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(75, 24, 'banner_slides_1_slide_ctas', ''),
(76, 24, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(77, 24, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(78, 24, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(79, 25, 'banner_slides_0_banner_background', 'image'),
(80, 25, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(81, 25, 'banner_slides_0_slide_title', 'Banner Slide1'),
(82, 25, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(83, 25, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(84, 25, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(85, 25, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(86, 25, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(87, 25, 'banner_slides_0_slide_ctas', '1'),
(88, 25, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(89, 25, 'banner_slides_0_slide_image', '22'),
(90, 25, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(91, 25, 'banner_slides', '2'),
(92, 25, '_banner_slides', 'field_606b1df75a8cf'),
(93, 25, 'banner_slides_1_banner_background', 'video'),
(94, 25, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(95, 25, 'banner_slides_1_slide_title', 'Banner Slide2'),
(96, 25, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(97, 25, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(98, 25, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(99, 25, 'banner_slides_1_slide_ctas', ''),
(100, 25, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(101, 25, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(102, 25, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(103, 7, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(104, 7, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(105, 26, 'banner_slides_0_banner_background', 'image'),
(106, 26, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(107, 26, 'banner_slides_0_slide_title', 'Banner Slide1'),
(108, 26, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(109, 26, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(110, 26, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(111, 26, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(112, 26, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(113, 26, 'banner_slides_0_slide_ctas', '1'),
(114, 26, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(115, 26, 'banner_slides_0_slide_image', '22'),
(116, 26, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(117, 26, 'banner_slides', '2'),
(118, 26, '_banner_slides', 'field_606b1df75a8cf'),
(119, 26, 'banner_slides_1_banner_background', 'video'),
(120, 26, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(121, 26, 'banner_slides_1_slide_title', 'Banner Slide2'),
(122, 26, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(123, 26, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(124, 26, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(125, 26, 'banner_slides_1_slide_ctas', '1'),
(126, 26, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(127, 26, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(128, 26, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(129, 26, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(130, 26, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(131, 27, '_wp_attached_file', '2021/04/banner2.mp4'),
(132, 27, '_wp_attachment_metadata', 'a:10:{s:7:\"bitrate\";i:5498561;s:8:\"filesize\";i:36738436;s:9:\"mime_type\";s:15:\"video/quicktime\";s:6:\"length\";i:53;s:16:\"length_formatted\";s:4:\"0:53\";s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:10:\"fileformat\";s:3:\"mp4\";s:10:\"dataformat\";s:9:\"quicktime\";s:17:\"created_timestamp\";i:1580838665;}'),
(133, 7, 'banner_slides_1_slide_image', '29'),
(134, 7, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(135, 28, 'banner_slides_0_banner_background', 'image'),
(136, 28, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(137, 28, 'banner_slides_0_slide_title', 'Banner Slide1'),
(138, 28, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(139, 28, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(140, 28, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(141, 28, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(142, 28, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(143, 28, 'banner_slides_0_slide_ctas', '1'),
(144, 28, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(145, 28, 'banner_slides_0_slide_image', '22'),
(146, 28, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(147, 28, 'banner_slides', '2'),
(148, 28, '_banner_slides', 'field_606b1df75a8cf'),
(149, 28, 'banner_slides_1_banner_background', 'video'),
(150, 28, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(151, 28, 'banner_slides_1_slide_title', 'Banner Slide2'),
(152, 28, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(153, 28, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(154, 28, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(155, 28, 'banner_slides_1_slide_ctas', '1'),
(156, 28, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(157, 28, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(158, 28, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(159, 28, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(160, 28, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(161, 28, 'banner_slides_1_slide_image', '27'),
(162, 28, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(163, 29, '_wp_attached_file', '2021/04/banner3.jpg'),
(164, 29, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:4:\"file\";s:19:\"2021/04/banner3.jpg\";s:5:\"sizes\";a:5:{s:6:\"medium\";a:4:{s:4:\"file\";s:19:\"banner3-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:20:\"banner3-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:19:\"banner3-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:19:\"banner3-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:20:\"banner3-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(165, 30, 'banner_slides_0_banner_background', 'image'),
(166, 30, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(167, 30, 'banner_slides_0_slide_title', 'Banner Slide1'),
(168, 30, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(169, 30, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(170, 30, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(171, 30, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(172, 30, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(173, 30, 'banner_slides_0_slide_ctas', '1'),
(174, 30, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(175, 30, 'banner_slides_0_slide_image', '22'),
(176, 30, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(177, 30, 'banner_slides', '2'),
(178, 30, '_banner_slides', 'field_606b1df75a8cf'),
(179, 30, 'banner_slides_1_banner_background', 'video'),
(180, 30, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(181, 30, 'banner_slides_1_slide_title', 'Banner Slide2'),
(182, 30, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(183, 30, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(184, 30, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(185, 30, 'banner_slides_1_slide_ctas', '1'),
(186, 30, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(187, 30, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(188, 30, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(189, 30, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(190, 30, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(191, 30, 'banner_slides_1_slide_image', '29'),
(192, 30, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(193, 29, '_wp_attachment_image_alt', 'Slide3 Banner Home Page'),
(194, 31, '_edit_last', '1'),
(195, 31, '_edit_lock', '1617880495:1'),
(196, 34, 'banner_slides_0_banner_background', 'image'),
(197, 34, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(198, 34, 'banner_slides_0_slide_title', 'Banner Slide1'),
(199, 34, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(200, 34, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(201, 34, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(202, 34, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(203, 34, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(204, 34, 'banner_slides_0_slide_ctas', '1'),
(205, 34, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(206, 34, 'banner_slides_0_slide_image', '22'),
(207, 34, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(208, 34, 'banner_slides', '2'),
(209, 34, '_banner_slides', 'field_606b1df75a8cf'),
(210, 34, 'banner_slides_1_banner_background', 'video'),
(211, 34, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(212, 34, 'banner_slides_1_slide_title', 'Banner Slide2'),
(213, 34, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(214, 34, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(215, 34, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(216, 34, 'banner_slides_1_slide_ctas', '1'),
(217, 34, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(218, 34, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(219, 34, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(220, 34, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(221, 34, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(222, 34, 'banner_slides_1_slide_image', '29'),
(223, 34, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(224, 35, '_wp_attached_file', '2021/04/surfing-e1618120788527.jpg'),
(225, 35, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:400;s:6:\"height\";i:499;s:4:\"file\";s:34:\"2021/04/surfing-e1618120788527.jpg\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:34:\"surfing-e1618120788527-240x300.jpg\";s:5:\"width\";i:240;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:34:\"surfing-e1618120788527-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(226, 7, 'about_image', '35'),
(227, 7, '_about_image', 'field_606b37798d9ed'),
(228, 36, 'banner_slides_0_banner_background', 'image'),
(229, 36, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(230, 36, 'banner_slides_0_slide_title', 'Banner Slide1'),
(231, 36, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(232, 36, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(233, 36, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(234, 36, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(235, 36, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(236, 36, 'banner_slides_0_slide_ctas', '1'),
(237, 36, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(238, 36, 'banner_slides_0_slide_image', '22'),
(239, 36, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(240, 36, 'banner_slides', '2'),
(241, 36, '_banner_slides', 'field_606b1df75a8cf'),
(242, 36, 'banner_slides_1_banner_background', 'video'),
(243, 36, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(244, 36, 'banner_slides_1_slide_title', 'Banner Slide2'),
(245, 36, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(246, 36, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(247, 36, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(248, 36, 'banner_slides_1_slide_ctas', '1'),
(249, 36, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(250, 36, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(251, 36, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(252, 36, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(253, 36, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(254, 36, 'banner_slides_1_slide_image', '29'),
(255, 36, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(256, 36, 'about_image', '35'),
(257, 36, '_about_image', 'field_606b37798d9ed'),
(258, 7, 'about_section_heading', 'About Us'),
(259, 7, '_about_section_heading', 'field_606b3a831710c'),
(260, 7, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(261, 7, '_about_section_description', 'field_606b3a901710d'),
(262, 39, 'banner_slides_0_banner_background', 'image'),
(263, 39, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(264, 39, 'banner_slides_0_slide_title', 'Banner Slide1'),
(265, 39, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(266, 39, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(267, 39, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(268, 39, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(269, 39, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(270, 39, 'banner_slides_0_slide_ctas', '1'),
(271, 39, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(272, 39, 'banner_slides_0_slide_image', '22'),
(273, 39, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(274, 39, 'banner_slides', '2'),
(275, 39, '_banner_slides', 'field_606b1df75a8cf'),
(276, 39, 'banner_slides_1_banner_background', 'video'),
(277, 39, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(278, 39, 'banner_slides_1_slide_title', 'Banner Slide2'),
(279, 39, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(280, 39, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(281, 39, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(282, 39, 'banner_slides_1_slide_ctas', '1'),
(283, 39, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(284, 39, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(285, 39, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(286, 39, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(287, 39, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(288, 39, 'banner_slides_1_slide_image', '29'),
(289, 39, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(290, 39, 'about_image', '35'),
(291, 39, '_about_image', 'field_606b37798d9ed'),
(292, 39, 'about_section_heading', 'About Us'),
(293, 39, '_about_section_heading', 'field_606b3a831710c'),
(294, 39, 'about_section_description', 'This is About Section Description Text.'),
(295, 39, '_about_section_description', 'field_606b3a901710d'),
(296, 40, 'banner_slides_0_banner_background', 'image'),
(297, 40, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(298, 40, 'banner_slides_0_slide_title', 'Banner Slide1'),
(299, 40, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(300, 40, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(301, 40, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(302, 40, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(303, 40, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(304, 40, 'banner_slides_0_slide_ctas', '1'),
(305, 40, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(306, 40, 'banner_slides_0_slide_image', '22'),
(307, 40, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(308, 40, 'banner_slides', '2'),
(309, 40, '_banner_slides', 'field_606b1df75a8cf'),
(310, 40, 'banner_slides_1_banner_background', 'video'),
(311, 40, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(312, 40, 'banner_slides_1_slide_title', 'Banner Slide2'),
(313, 40, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(314, 40, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(315, 40, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(316, 40, 'banner_slides_1_slide_ctas', '1'),
(317, 40, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(318, 40, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(319, 40, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(320, 40, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(321, 40, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(322, 40, 'banner_slides_1_slide_image', '29'),
(323, 40, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(324, 40, 'about_image', '35'),
(325, 40, '_about_image', 'field_606b37798d9ed'),
(326, 40, 'about_section_heading', 'About Us'),
(327, 40, '_about_section_heading', 'field_606b3a831710c'),
(328, 40, 'about_section_description', 'This is About the Section Description Text.'),
(329, 40, '_about_section_description', 'field_606b3a901710d'),
(330, 7, 'slider_style', 'no-navigation'),
(331, 7, '_slider_style', 'field_606ee66719776'),
(332, 40, 'slider_style', 'arrow-only'),
(333, 40, '_slider_style', 'field_606ee66719776'),
(334, 2, '_edit_lock', '1617881881:1'),
(335, 2, '_edit_last', '1'),
(336, 2, 'slider_style', 'arrow-only'),
(337, 2, '_slider_style', 'field_606ee66719776'),
(338, 2, 'banner_slides', '1'),
(339, 2, '_banner_slides', 'field_606b1df75a8cf'),
(340, 42, 'slider_style', 'arrow-only'),
(341, 42, '_slider_style', 'field_606ee66719776'),
(342, 42, 'banner_slides', ''),
(343, 42, '_banner_slides', 'field_606b1df75a8cf'),
(344, 43, 'slider_style', 'arrow-only'),
(345, 43, '_slider_style', 'field_606ee66719776'),
(346, 43, 'banner_slides', ''),
(347, 43, '_banner_slides', 'field_606b1df75a8cf'),
(348, 2, 'banner_slides_0_slide_title', 'About Us'),
(349, 2, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(350, 2, 'banner_slides_0_slide_description', 'About Us  Description'),
(351, 2, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(352, 2, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:3:\"ABC\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(353, 2, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(354, 2, 'banner_slides_0_slide_ctas', '1'),
(355, 2, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(356, 2, 'banner_slides_0_slide_image', '29'),
(357, 2, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(358, 44, 'slider_style', 'arrow-only'),
(359, 44, '_slider_style', 'field_606ee66719776'),
(360, 44, 'banner_slides', '1'),
(361, 44, '_banner_slides', 'field_606b1df75a8cf'),
(362, 44, 'banner_slides_0_slide_title', 'About Us'),
(363, 44, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(364, 44, 'banner_slides_0_slide_description', 'About Us  Description'),
(365, 44, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(366, 44, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:3:\"ABC\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(367, 44, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(368, 44, 'banner_slides_0_slide_ctas', '1'),
(369, 44, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(370, 44, 'banner_slides_0_slide_image', '29'),
(371, 44, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(372, 45, 'slider_style', 'arrow-only'),
(373, 45, '_slider_style', 'field_606ee66719776'),
(374, 45, 'banner_slides', '1'),
(375, 45, '_banner_slides', 'field_606b1df75a8cf'),
(376, 45, 'banner_slides_0_slide_title', 'About Us'),
(377, 45, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(378, 45, 'banner_slides_0_slide_description', 'About Us  Description'),
(379, 45, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(380, 45, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:3:\"ABC\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(381, 45, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(382, 45, 'banner_slides_0_slide_ctas', '1'),
(383, 45, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(384, 45, 'banner_slides_0_slide_image', '29'),
(385, 45, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(386, 47, 'slider_style', 'arrow-only'),
(387, 47, '_slider_style', 'field_606ee66719776'),
(388, 47, 'banner_slides', '1'),
(389, 47, '_banner_slides', 'field_606b1df75a8cf'),
(390, 47, 'banner_slides_0_slide_title', 'About Us'),
(391, 47, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(392, 47, 'banner_slides_0_slide_description', 'About Us  Description'),
(393, 47, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(394, 47, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:3:\"ABC\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(395, 47, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(396, 47, 'banner_slides_0_slide_ctas', '1'),
(397, 47, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(398, 47, 'banner_slides_0_slide_image', '29'),
(399, 47, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(400, 48, '_edit_lock', '1617881963:1'),
(403, 51, '_edit_lock', '1617884842:1'),
(404, 51, '_edit_last', '1'),
(406, 53, '_edit_lock', '1617883346:1'),
(407, 53, '_edit_last', '1'),
(413, 51, '_thumbnail_id', '29'),
(414, 56, '_wp_attached_file', '2021/04/logo-stjulien@2x.png'),
(415, 56, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:407;s:6:\"height\";i:147;s:4:\"file\";s:28:\"2021/04/logo-stjulien@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:28:\"logo-stjulien@2x-300x108.png\";s:5:\"width\";i:300;s:6:\"height\";i:108;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"logo-stjulien@2x-150x147.png\";s:5:\"width\";i:150;s:6:\"height\";i:147;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(416, 57, '_wp_trash_meta_status', 'publish'),
(417, 57, '_wp_trash_meta_time', '1618031655'),
(418, 58, '_wp_attached_file', '2021/04/logo-treslatin@2x-e1618031674978.png'),
(419, 58, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:64;s:6:\"height\";i:64;s:4:\"file\";s:44:\"2021/04/logo-treslatin@2x-e1618031674978.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:29:\"logo-treslatin@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(420, 58, '_edit_lock', '1618041531:1'),
(421, 58, '_wp_attachment_backup_sizes', 'a:1:{s:9:\"full-orig\";a:3:{s:5:\"width\";i:227;s:6:\"height\";i:227;s:4:\"file\";s:21:\"logo-treslatin@2x.png\";}}'),
(422, 58, '_edit_last', '1'),
(423, 59, '_wp_trash_meta_status', 'publish'),
(424, 59, '_wp_trash_meta_time', '1618031698'),
(425, 60, 'banner_slides_0_banner_background', 'image'),
(426, 60, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(427, 60, 'banner_slides_0_slide_title', 'Banner Slide1'),
(428, 60, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(429, 60, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(430, 60, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(431, 60, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(432, 60, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(433, 60, 'banner_slides_0_slide_ctas', '1'),
(434, 60, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(435, 60, 'banner_slides_0_slide_image', '22'),
(436, 60, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(437, 60, 'banner_slides', '2'),
(438, 60, '_banner_slides', 'field_606b1df75a8cf'),
(439, 60, 'banner_slides_1_banner_background', 'video'),
(440, 60, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(441, 60, 'banner_slides_1_slide_title', 'Banner Slide2'),
(442, 60, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(443, 60, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(444, 60, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(445, 60, 'banner_slides_1_slide_ctas', '1'),
(446, 60, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(447, 60, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(448, 60, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(449, 60, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(450, 60, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(451, 60, 'banner_slides_1_slide_image', '29'),
(452, 60, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(453, 60, 'about_image', '35'),
(454, 60, '_about_image', 'field_606b37798d9ed'),
(455, 60, 'about_section_heading', 'About Us'),
(456, 60, '_about_section_heading', 'field_606b3a831710c'),
(457, 60, 'about_section_description', 'This is About the Section Description Text.'),
(458, 60, '_about_section_description', 'field_606b3a901710d'),
(459, 60, 'slider_style', 'dots-only'),
(460, 60, '_slider_style', 'field_606ee66719776'),
(461, 61, 'banner_slides_0_banner_background', 'image'),
(462, 61, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(463, 61, 'banner_slides_0_slide_title', 'Banner Slide1'),
(464, 61, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(465, 61, 'banner_slides_0_slide_description', 'This is Description of Slide one.'),
(466, 61, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(467, 61, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(468, 61, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(469, 61, 'banner_slides_0_slide_ctas', '1'),
(470, 61, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(471, 61, 'banner_slides_0_slide_image', '22'),
(472, 61, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(473, 61, 'banner_slides', '2'),
(474, 61, '_banner_slides', 'field_606b1df75a8cf'),
(475, 61, 'banner_slides_1_banner_background', 'video'),
(476, 61, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(477, 61, 'banner_slides_1_slide_title', 'Banner Slide2'),
(478, 61, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(479, 61, 'banner_slides_1_slide_description', 'This is Description of Slide Two.'),
(480, 61, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(481, 61, 'banner_slides_1_slide_ctas', '1'),
(482, 61, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(483, 61, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(484, 61, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(485, 61, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(486, 61, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(487, 61, 'banner_slides_1_slide_image', '29'),
(488, 61, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(489, 61, 'about_image', '35'),
(490, 61, '_about_image', 'field_606b37798d9ed'),
(491, 61, 'about_section_heading', 'About Us'),
(492, 61, '_about_section_heading', 'field_606b3a831710c'),
(493, 61, 'about_section_description', 'This is About the Section Description Text.'),
(494, 61, '_about_section_description', 'field_606b3a901710d'),
(495, 61, 'slider_style', 'arrow-dots'),
(496, 61, '_slider_style', 'field_606ee66719776'),
(497, 62, '_form', '[text* email-182 placeholder \"Your Name\"]\n[email* url-15 placeholder \"Your Email\"]\n<div>Date Of Birth : [date* textarea-498 placeholder \"Date of Birth\"]</div>\n<div>Select Option : [select* menu-741 include_blank \"Dropdown Item1\" \"Dropdown Item2\" \"Dropdown Item3\" \"Dropdown Item4\"]</div>\n[textarea* menu-875 placeholder \"Message\"]\n[checkbox* checkbox-828 use_label_element \"I do Agree With Terms and Conditions.\"]\n[submit]'),
(498, 62, '_mail', 'a:9:{s:6:\"active\";b:1;s:7:\"subject\";s:0:\"\";s:6:\"sender\";s:44:\"[_site_title] <patel.truptesh1996@gmail.com>\";s:9:\"recipient\";s:19:\"[_site_admin_email]\";s:4:\"body\";s:0:\"\";s:18:\"additional_headers\";s:0:\"\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";b:0;s:13:\"exclude_blank\";b:0;}'),
(499, 62, '_mail_2', 'a:9:{s:6:\"active\";b:0;s:7:\"subject\";s:30:\"[_site_title] \"[your-subject]\"\";s:6:\"sender\";s:44:\"[_site_title] <patel.truptesh1996@gmail.com>\";s:9:\"recipient\";s:12:\"[your-email]\";s:4:\"body\";s:105:\"Message Body:\n[your-message]\n\n-- \nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\";s:18:\"additional_headers\";s:29:\"Reply-To: [_site_admin_email]\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";b:0;s:13:\"exclude_blank\";b:0;}'),
(500, 62, '_messages', 'a:22:{s:12:\"mail_sent_ok\";s:45:\"Thank you for your message. It has been sent.\";s:12:\"mail_sent_ng\";s:71:\"There was an error trying to send your message. Please try again later.\";s:16:\"validation_error\";s:61:\"One or more fields have an error. Please check and try again.\";s:4:\"spam\";s:71:\"There was an error trying to send your message. Please try again later.\";s:12:\"accept_terms\";s:69:\"You must accept the terms and conditions before sending your message.\";s:16:\"invalid_required\";s:22:\"The field is required.\";s:16:\"invalid_too_long\";s:22:\"The field is too long.\";s:17:\"invalid_too_short\";s:23:\"The field is too short.\";s:13:\"upload_failed\";s:46:\"There was an unknown error uploading the file.\";s:24:\"upload_file_type_invalid\";s:49:\"You are not allowed to upload files of this type.\";s:21:\"upload_file_too_large\";s:20:\"The file is too big.\";s:23:\"upload_failed_php_error\";s:38:\"There was an error uploading the file.\";s:12:\"invalid_date\";s:29:\"The date format is incorrect.\";s:14:\"date_too_early\";s:44:\"The date is before the earliest one allowed.\";s:13:\"date_too_late\";s:41:\"The date is after the latest one allowed.\";s:14:\"invalid_number\";s:29:\"The number format is invalid.\";s:16:\"number_too_small\";s:47:\"The number is smaller than the minimum allowed.\";s:16:\"number_too_large\";s:46:\"The number is larger than the maximum allowed.\";s:23:\"quiz_answer_not_correct\";s:36:\"The answer to the quiz is incorrect.\";s:13:\"invalid_email\";s:38:\"The e-mail address entered is invalid.\";s:11:\"invalid_url\";s:19:\"The URL is invalid.\";s:11:\"invalid_tel\";s:32:\"The telephone number is invalid.\";}'),
(501, 62, '_additional_settings', ''),
(502, 62, '_locale', 'en_US'),
(503, 64, '_edit_last', '1'),
(504, 64, '_edit_lock', '1618053306:1'),
(512, 69, '_edit_lock', '1618126635:1'),
(513, 69, '_edit_last', '1'),
(514, 69, 'slider_style', 'arrow-only'),
(515, 69, '_slider_style', 'field_606ee66719776'),
(516, 69, 'banner_slides', ''),
(517, 69, '_banner_slides', 'field_606b1df75a8cf'),
(518, 70, 'slider_style', 'arrow-only'),
(519, 70, '_slider_style', 'field_606ee66719776'),
(520, 70, 'banner_slides', ''),
(521, 70, '_banner_slides', 'field_606b1df75a8cf'),
(522, 69, '_wp_page_template', 'page-template/contact-template.php'),
(523, 71, '_wp_trash_meta_status', 'publish'),
(524, 71, '_wp_trash_meta_time', '1618053577'),
(525, 73, '_menu_item_type', 'post_type'),
(526, 73, '_menu_item_menu_item_parent', '0'),
(527, 73, '_menu_item_object_id', '2'),
(528, 73, '_menu_item_object', 'page'),
(529, 73, '_menu_item_target', ''),
(530, 73, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(531, 73, '_menu_item_xfn', ''),
(532, 73, '_menu_item_url', ''),
(533, 74, '_menu_item_type', 'post_type'),
(534, 74, '_menu_item_menu_item_parent', '0'),
(535, 74, '_menu_item_object_id', '69'),
(536, 74, '_menu_item_object', 'page'),
(537, 74, '_menu_item_target', ''),
(538, 74, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(539, 74, '_menu_item_xfn', ''),
(540, 74, '_menu_item_url', ''),
(541, 72, '_wp_trash_meta_status', 'publish'),
(542, 72, '_wp_trash_meta_time', '1618053590'),
(543, 75, 'banner_slides_0_banner_background', 'image'),
(544, 75, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(545, 75, 'banner_slides_0_slide_title', 'Banner Slide1'),
(546, 75, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(547, 75, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(548, 75, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(549, 75, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(550, 75, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(551, 75, 'banner_slides_0_slide_ctas', '1'),
(552, 75, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(553, 75, 'banner_slides_0_slide_image', '22'),
(554, 75, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(555, 75, 'banner_slides', '2'),
(556, 75, '_banner_slides', 'field_606b1df75a8cf'),
(557, 75, 'banner_slides_1_banner_background', 'video'),
(558, 75, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(559, 75, 'banner_slides_1_slide_title', 'Banner Slide2'),
(560, 75, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(561, 75, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(562, 75, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(563, 75, 'banner_slides_1_slide_ctas', '1'),
(564, 75, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(565, 75, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(566, 75, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(567, 75, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(568, 75, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(569, 75, 'banner_slides_1_slide_image', '29'),
(570, 75, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(571, 75, 'about_image', '35'),
(572, 75, '_about_image', 'field_606b37798d9ed'),
(573, 75, 'about_section_heading', 'About Us'),
(574, 75, '_about_section_heading', 'field_606b3a831710c'),
(575, 75, 'about_section_description', 'This is About the Section Description Text.'),
(576, 75, '_about_section_description', 'field_606b3a901710d'),
(577, 75, 'slider_style', 'arrow-dots'),
(578, 75, '_slider_style', 'field_606ee66719776'),
(579, 76, 'banner_slides_0_banner_background', 'image'),
(580, 76, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(581, 76, 'banner_slides_0_slide_title', 'Banner Slide1'),
(582, 76, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(583, 76, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(584, 76, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(585, 76, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(586, 76, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(587, 76, 'banner_slides_0_slide_ctas', '1'),
(588, 76, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(589, 76, 'banner_slides_0_slide_image', '22'),
(590, 76, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(591, 76, 'banner_slides', '2'),
(592, 76, '_banner_slides', 'field_606b1df75a8cf'),
(593, 76, 'banner_slides_1_banner_background', 'video'),
(594, 76, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(595, 76, 'banner_slides_1_slide_title', 'Banner Slide2'),
(596, 76, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(597, 76, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(598, 76, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(599, 76, 'banner_slides_1_slide_ctas', '1'),
(600, 76, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(601, 76, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(602, 76, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(603, 76, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(604, 76, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(605, 76, 'banner_slides_1_slide_image', '29'),
(606, 76, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(607, 76, 'about_image', '35'),
(608, 76, '_about_image', 'field_606b37798d9ed'),
(609, 76, 'about_section_heading', 'About Us'),
(610, 76, '_about_section_heading', 'field_606b3a831710c'),
(611, 76, 'about_section_description', 'This is About the Section Description Text.'),
(612, 76, '_about_section_description', 'field_606b3a901710d'),
(613, 76, 'slider_style', 'arrow-dots'),
(614, 76, '_slider_style', 'field_606ee66719776'),
(615, 77, 'banner_slides_0_banner_background', 'image'),
(616, 77, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(617, 77, 'banner_slides_0_slide_title', 'Banner Slide1'),
(618, 77, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(619, 77, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(620, 77, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(621, 77, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(622, 77, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(623, 77, 'banner_slides_0_slide_ctas', '1'),
(624, 77, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(625, 77, 'banner_slides_0_slide_image', '22'),
(626, 77, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(627, 77, 'banner_slides', '2'),
(628, 77, '_banner_slides', 'field_606b1df75a8cf'),
(629, 77, 'banner_slides_1_banner_background', 'video'),
(630, 77, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(631, 77, 'banner_slides_1_slide_title', 'Banner Slide2'),
(632, 77, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(633, 77, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(634, 77, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(635, 77, 'banner_slides_1_slide_ctas', '1'),
(636, 77, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(637, 77, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(638, 77, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(639, 77, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(640, 77, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(641, 77, 'banner_slides_1_slide_image', '29'),
(642, 77, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(643, 77, 'about_image', '35'),
(644, 77, '_about_image', 'field_606b37798d9ed'),
(645, 77, 'about_section_heading', 'About Us'),
(646, 77, '_about_section_heading', 'field_606b3a831710c'),
(647, 77, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(648, 77, '_about_section_description', 'field_606b3a901710d'),
(649, 77, 'slider_style', 'arrow-dots'),
(650, 77, '_slider_style', 'field_606ee66719776'),
(651, 35, '_wp_attachment_backup_sizes', 'a:4:{s:9:\"full-orig\";a:3:{s:5:\"width\";i:600;s:6:\"height\";i:900;s:4:\"file\";s:11:\"surfing.jpg\";}s:18:\"full-1618120788527\";a:3:{s:5:\"width\";i:400;s:6:\"height\";i:600;s:4:\"file\";s:26:\"surfing-e1618057335140.jpg\";}s:14:\"thumbnail-orig\";a:4:{s:4:\"file\";s:19:\"surfing-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"medium-orig\";a:4:{s:4:\"file\";s:19:\"surfing-200x300.jpg\";s:5:\"width\";i:200;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}}'),
(652, 78, 'banner_slides_0_banner_background', 'image'),
(653, 78, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(654, 78, 'banner_slides_0_slide_title', 'Banner Slide1'),
(655, 78, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(656, 78, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(657, 78, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(658, 78, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(659, 78, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(660, 78, 'banner_slides_0_slide_ctas', '1'),
(661, 78, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(662, 78, 'banner_slides_0_slide_image', '22'),
(663, 78, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(664, 78, 'banner_slides', '2'),
(665, 78, '_banner_slides', 'field_606b1df75a8cf'),
(666, 78, 'banner_slides_1_banner_background', 'video'),
(667, 78, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(668, 78, 'banner_slides_1_slide_title', 'Banner Slide2'),
(669, 78, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(670, 78, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(671, 78, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(672, 78, 'banner_slides_1_slide_ctas', '1'),
(673, 78, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(674, 78, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(675, 78, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(676, 78, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(677, 78, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(678, 78, 'banner_slides_1_slide_image', '29');
INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(679, 78, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(680, 78, 'about_image', '35'),
(681, 78, '_about_image', 'field_606b37798d9ed'),
(682, 78, 'about_section_heading', 'About Us'),
(683, 78, '_about_section_heading', 'field_606b3a831710c'),
(684, 78, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(685, 78, '_about_section_description', 'field_606b3a901710d'),
(686, 78, 'slider_style', 'arrow-dots'),
(687, 78, '_slider_style', 'field_606ee66719776'),
(688, 79, '_wp_attached_file', '2021/04/logo-baileys@2x.png'),
(689, 79, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:346;s:6:\"height\";i:154;s:4:\"file\";s:27:\"2021/04/logo-baileys@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:27:\"logo-baileys@2x-300x134.png\";s:5:\"width\";i:300;s:6:\"height\";i:134;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"logo-baileys@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(690, 80, '_wp_attached_file', '2021/04/logo-breckbrewery@2x.png'),
(691, 80, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:298;s:6:\"height\";i:299;s:4:\"file\";s:32:\"2021/04/logo-breckbrewery@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:32:\"logo-breckbrewery@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(692, 81, '_wp_attached_file', '2021/04/logo-dali@2x.png'),
(693, 81, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:428;s:6:\"height\";i:143;s:4:\"file\";s:24:\"2021/04/logo-dali@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:24:\"logo-dali@2x-300x100.png\";s:5:\"width\";i:300;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"logo-dali@2x-150x143.png\";s:5:\"width\";i:150;s:6:\"height\";i:143;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(694, 82, '_wp_attached_file', '2021/04/logo-delight@2x.png'),
(695, 82, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:380;s:6:\"height\";i:161;s:4:\"file\";s:27:\"2021/04/logo-delight@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:27:\"logo-delight@2x-300x127.png\";s:5:\"width\";i:300;s:6:\"height\";i:127;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"logo-delight@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(696, 83, '_wp_attached_file', '2021/04/logo-dmns@2x.png'),
(697, 83, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:279;s:6:\"height\";i:87;s:4:\"file\";s:24:\"2021/04/logo-dmns@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"logo-dmns@2x-150x87.png\";s:5:\"width\";i:150;s:6:\"height\";i:87;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(698, 84, '_wp_attached_file', '2021/04/logo-dunkin@2x.png'),
(699, 84, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:431;s:6:\"height\";i:78;s:4:\"file\";s:26:\"2021/04/logo-dunkin@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:25:\"logo-dunkin@2x-300x54.png\";s:5:\"width\";i:300;s:6:\"height\";i:54;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"logo-dunkin@2x-150x78.png\";s:5:\"width\";i:150;s:6:\"height\";i:78;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(700, 85, '_wp_attached_file', '2021/04/logo-honesttogoodness@2x.png'),
(701, 85, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:439;s:6:\"height\";i:129;s:4:\"file\";s:36:\"2021/04/logo-honesttogoodness@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:35:\"logo-honesttogoodness@2x-300x88.png\";s:5:\"width\";i:300;s:6:\"height\";i:88;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:36:\"logo-honesttogoodness@2x-150x129.png\";s:5:\"width\";i:150;s:6:\"height\";i:129;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(702, 86, '_wp_attached_file', '2021/04/logo-horizon@2x.png'),
(703, 86, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:337;s:6:\"height\";i:145;s:4:\"file\";s:27:\"2021/04/logo-horizon@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:27:\"logo-horizon@2x-300x129.png\";s:5:\"width\";i:300;s:6:\"height\";i:129;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"logo-horizon@2x-150x145.png\";s:5:\"width\";i:150;s:6:\"height\";i:145;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(704, 87, '_wp_attached_file', '2021/04/logo-min@2x.png'),
(705, 87, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:300;s:6:\"height\";i:188;s:4:\"file\";s:23:\"2021/04/logo-min@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"logo-min@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(706, 88, '_wp_attached_file', '2021/04/logo-oikos@2x.png'),
(707, 88, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:420;s:6:\"height\";i:100;s:4:\"file\";s:25:\"2021/04/logo-oikos@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:24:\"logo-oikos@2x-300x71.png\";s:5:\"width\";i:300;s:6:\"height\";i:71;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"logo-oikos@2x-150x100.png\";s:5:\"width\";i:150;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(708, 89, '_wp_attached_file', '2021/04/logo-panasonic@2x.png'),
(709, 89, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:412;s:6:\"height\";i:62;s:4:\"file\";s:29:\"2021/04/logo-panasonic@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:28:\"logo-panasonic@2x-300x45.png\";s:5:\"width\";i:300;s:6:\"height\";i:45;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"logo-panasonic@2x-150x62.png\";s:5:\"width\";i:150;s:6:\"height\";i:62;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(710, 90, '_wp_attached_file', '2021/04/logo-rad@2x.png'),
(711, 90, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:209;s:6:\"height\";i:119;s:4:\"file\";s:23:\"2021/04/logo-rad@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"logo-rad@2x-150x119.png\";s:5:\"width\";i:150;s:6:\"height\";i:119;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(712, 91, '_wp_attached_file', '2021/04/logo-silk@2x.png'),
(713, 91, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:240;s:6:\"height\";i:153;s:4:\"file\";s:24:\"2021/04/logo-silk@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"logo-silk@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(714, 92, '_wp_attached_file', '2021/04/logo-stjulien@2x-1.png'),
(715, 92, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:407;s:6:\"height\";i:147;s:4:\"file\";s:30:\"2021/04/logo-stjulien@2x-1.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:30:\"logo-stjulien@2x-1-300x108.png\";s:5:\"width\";i:300;s:6:\"height\";i:108;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:30:\"logo-stjulien@2x-1-150x147.png\";s:5:\"width\";i:150;s:6:\"height\";i:147;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(716, 93, '_wp_attached_file', '2021/04/logo-stok@2x.png'),
(717, 93, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:257;s:6:\"height\";i:147;s:4:\"file\";s:24:\"2021/04/logo-stok@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"logo-stok@2x-150x147.png\";s:5:\"width\";i:150;s:6:\"height\";i:147;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(718, 94, '_wp_attached_file', '2021/04/logo-tervis@2x.png'),
(719, 94, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:367;s:6:\"height\";i:90;s:4:\"file\";s:26:\"2021/04/logo-tervis@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:25:\"logo-tervis@2x-300x74.png\";s:5:\"width\";i:300;s:6:\"height\";i:74;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"logo-tervis@2x-150x90.png\";s:5:\"width\";i:150;s:6:\"height\";i:90;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(720, 95, '_wp_attached_file', '2021/04/logo-treslatin@2x-1.png'),
(721, 95, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:227;s:6:\"height\";i:227;s:4:\"file\";s:31:\"2021/04/logo-treslatin@2x-1.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:31:\"logo-treslatin@2x-1-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(722, 96, '_wp_attached_file', '2021/04/logo-trimble@2x.png'),
(723, 96, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:473;s:6:\"height\";i:111;s:4:\"file\";s:27:\"2021/04/logo-trimble@2x.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"logo-trimble@2x-300x70.png\";s:5:\"width\";i:300;s:6:\"height\";i:70;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"logo-trimble@2x-150x111.png\";s:5:\"width\";i:150;s:6:\"height\";i:111;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(724, 97, '_wp_attached_file', '2021/04/logo-wildmade@2x.png'),
(725, 97, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:247;s:6:\"height\";i:231;s:4:\"file\";s:28:\"2021/04/logo-wildmade@2x.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"logo-wildmade@2x-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(738, 99, 'banner_slides_0_banner_background', 'image'),
(739, 99, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(740, 99, 'banner_slides_0_slide_title', 'Banner Slide'),
(741, 99, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(742, 99, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(743, 99, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(744, 99, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Contact Us\";s:3:\"url\";s:34:\"http://localhost/eveal/contact-us/\";s:6:\"target\";s:0:\"\";}'),
(745, 99, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(746, 99, 'banner_slides_0_slide_ctas', '1'),
(747, 99, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(748, 99, 'banner_slides_0_slide_image', '98'),
(749, 99, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(750, 99, 'banner_slides', '3'),
(751, 99, '_banner_slides', 'field_606b1df75a8cf'),
(752, 99, 'banner_slides_1_banner_background', 'video'),
(753, 99, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(754, 99, 'banner_slides_1_slide_title', 'Banner Slide1'),
(755, 99, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(756, 99, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(757, 99, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(758, 99, 'banner_slides_1_slide_ctas', '1'),
(759, 99, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(760, 99, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(761, 99, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(762, 99, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(763, 99, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(764, 99, 'banner_slides_1_slide_image', '22'),
(765, 99, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(766, 99, 'about_image', '35'),
(767, 99, '_about_image', 'field_606b37798d9ed'),
(768, 99, 'about_section_heading', 'About Us'),
(769, 99, '_about_section_heading', 'field_606b3a831710c'),
(770, 99, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(771, 99, '_about_section_description', 'field_606b3a901710d'),
(772, 99, 'slider_style', 'arrow-dots'),
(773, 99, '_slider_style', 'field_606ee66719776'),
(774, 99, 'banner_slides_2_slide_title', 'Banner Slide2'),
(775, 99, '_banner_slides_2_slide_title', 'field_606b2506b18dc'),
(776, 99, 'banner_slides_2_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(777, 99, '_banner_slides_2_slide_description', 'field_606b2515b18dd'),
(778, 99, 'banner_slides_2_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(779, 99, '_banner_slides_2_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(780, 99, 'banner_slides_2_slide_ctas', '1'),
(781, 99, '_banner_slides_2_slide_ctas', 'field_606b251bb18de'),
(782, 99, 'banner_slides_2_slide_image', '29'),
(783, 99, '_banner_slides_2_slide_image', 'field_606b2572cf56c'),
(784, 100, 'banner_slides_0_banner_background', 'image'),
(785, 100, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(786, 100, 'banner_slides_0_slide_title', 'Banner Slide1'),
(787, 100, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(788, 100, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(789, 100, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(790, 100, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(791, 100, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(792, 100, 'banner_slides_0_slide_ctas', '1'),
(793, 100, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(794, 100, 'banner_slides_0_slide_image', '22'),
(795, 100, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(796, 100, 'banner_slides', '2'),
(797, 100, '_banner_slides', 'field_606b1df75a8cf'),
(798, 100, 'banner_slides_1_banner_background', 'video'),
(799, 100, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(800, 100, 'banner_slides_1_slide_title', 'Banner Slide2'),
(801, 100, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(802, 100, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(803, 100, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(804, 100, 'banner_slides_1_slide_ctas', '1'),
(805, 100, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(806, 100, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(807, 100, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(808, 100, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(809, 100, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(810, 100, 'banner_slides_1_slide_image', '29'),
(811, 100, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(812, 100, 'about_image', '35'),
(813, 100, '_about_image', 'field_606b37798d9ed'),
(814, 100, 'about_section_heading', 'About Us'),
(815, 100, '_about_section_heading', 'field_606b3a831710c'),
(816, 100, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(817, 100, '_about_section_description', 'field_606b3a901710d'),
(818, 100, 'slider_style', 'arrow-dots'),
(819, 100, '_slider_style', 'field_606ee66719776'),
(820, 101, 'banner_slides_0_banner_background', 'image'),
(821, 101, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(822, 101, 'banner_slides_0_slide_title', 'Banner Slide1'),
(823, 101, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(824, 101, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(825, 101, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(826, 101, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(827, 101, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(828, 101, 'banner_slides_0_slide_ctas', '1'),
(829, 101, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(830, 101, 'banner_slides_0_slide_image', '22'),
(831, 101, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(832, 101, 'banner_slides', '2'),
(833, 101, '_banner_slides', 'field_606b1df75a8cf'),
(834, 101, 'banner_slides_1_banner_background', 'video'),
(835, 101, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(836, 101, 'banner_slides_1_slide_title', 'Banner Slide2'),
(837, 101, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(838, 101, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(839, 101, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(840, 101, 'banner_slides_1_slide_ctas', '1'),
(841, 101, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(842, 101, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(843, 101, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(844, 101, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(845, 101, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(846, 101, 'banner_slides_1_slide_image', '29'),
(847, 101, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(848, 101, 'about_image', '35'),
(849, 101, '_about_image', 'field_606b37798d9ed'),
(850, 101, 'about_section_heading', 'About Us'),
(851, 101, '_about_section_heading', 'field_606b3a831710c'),
(852, 101, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(853, 101, '_about_section_description', 'field_606b3a901710d'),
(854, 101, 'slider_style', 'arrow-dots'),
(855, 101, '_slider_style', 'field_606ee66719776'),
(856, 102, 'slider_style', 'arrow-only'),
(857, 102, '_slider_style', 'field_606ee66719776'),
(858, 102, 'banner_slides', ''),
(859, 102, '_banner_slides', 'field_606b1df75a8cf'),
(860, 62, '_config_errors', 'a:2:{s:12:\"mail.subject\";a:1:{i:0;a:2:{s:4:\"code\";i:101;s:4:\"args\";a:3:{s:7:\"message\";s:0:\"\";s:6:\"params\";a:0:{}s:4:\"link\";s:57:\"https://contactform7.com/configuration-errors/maybe-empty\";}}}s:9:\"mail.body\";a:1:{i:0;a:2:{s:4:\"code\";i:101;s:4:\"args\";a:3:{s:7:\"message\";s:0:\"\";s:6:\"params\";a:0:{}s:4:\"link\";s:57:\"https://contactform7.com/configuration-errors/maybe-empty\";}}}}'),
(861, 103, '_edit_last', '1'),
(862, 103, '_edit_lock', '1618134319:1'),
(863, 108, 'banner_slides_0_banner_background', 'image'),
(864, 108, '_banner_slides_0_banner_background', 'field_606b1e085a8d0'),
(865, 108, 'banner_slides_0_slide_title', 'Banner Slide1'),
(866, 108, '_banner_slides_0_slide_title', 'field_606b2506b18dc'),
(867, 108, 'banner_slides_0_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
(868, 108, '_banner_slides_0_slide_description', 'field_606b2515b18dd'),
(869, 108, 'banner_slides_0_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:9:\"Read More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(870, 108, '_banner_slides_0_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(871, 108, 'banner_slides_0_slide_ctas', '1'),
(872, 108, '_banner_slides_0_slide_ctas', 'field_606b251bb18de'),
(873, 108, 'banner_slides_0_slide_image', '22'),
(874, 108, '_banner_slides_0_slide_image', 'field_606b2572cf56c'),
(875, 108, 'banner_slides', '2'),
(876, 108, '_banner_slides', 'field_606b1df75a8cf'),
(877, 108, 'banner_slides_1_banner_background', 'video'),
(878, 108, '_banner_slides_1_banner_background', 'field_606b1e085a8d0'),
(879, 108, 'banner_slides_1_slide_title', 'Banner Slide2'),
(880, 108, '_banner_slides_1_slide_title', 'field_606b2506b18dc'),
(881, 108, 'banner_slides_1_slide_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(882, 108, '_banner_slides_1_slide_description', 'field_606b2515b18dd'),
(883, 108, 'banner_slides_1_slide_ctas', '1'),
(884, 108, '_banner_slides_1_slide_ctas', 'field_606b251bb18de'),
(885, 108, 'banner_slides_1_slide_video', 'https://www.youtube.com/watch?v=BHACKCNDMW8'),
(886, 108, '_banner_slides_1_slide_video', 'field_606b258ccf56d'),
(887, 108, 'banner_slides_1_slide_ctas_0_cta_item', 'a:3:{s:5:\"title\";s:10:\"Learn More\";s:3:\"url\";s:1:\"#\";s:6:\"target\";s:0:\"\";}'),
(888, 108, '_banner_slides_1_slide_ctas_0_cta_item', 'field_606b2534b18df'),
(889, 108, 'banner_slides_1_slide_image', '29'),
(890, 108, '_banner_slides_1_slide_image', 'field_606b2572cf56c'),
(891, 108, 'about_image', '35'),
(892, 108, '_about_image', 'field_606b37798d9ed'),
(893, 108, 'about_section_heading', 'About Us'),
(894, 108, '_about_section_heading', 'field_606b3a831710c'),
(895, 108, 'about_section_description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.'),
(896, 108, '_about_section_description', 'field_606b3a901710d'),
(897, 108, 'slider_style', 'no-navigation'),
(898, 108, '_slider_style', 'field_606ee66719776');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2021-04-05 13:24:05', '2021-04-05 13:24:05', '<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2021-04-05 13:24:05', '2021-04-05 13:24:05', '', 0, 'http://localhost/eveal/?p=1', 0, 'post', '', 1),
(2, 1, '2021-04-05 13:24:05', '2021-04-05 13:24:05', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'About', '', 'publish', 'closed', 'open', '', 'about', '', '', '2021-04-08 11:33:38', '2021-04-08 11:33:38', '', 0, 'http://localhost/eveal/?page_id=2', 0, 'page', '', 0),
(3, 1, '2021-04-05 13:24:05', '2021-04-05 13:24:05', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://localhost/eveal.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Comments</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Media</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Embedded content from other websites</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2021-04-05 13:24:05', '2021-04-05 13:24:05', '', 0, 'http://localhost/eveal/?page_id=3', 0, 'page', '', 0),
(4, 1, '2021-04-05 13:26:08', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2021-04-05 13:26:08', '0000-00-00 00:00:00', '', 0, 'http://localhost/eveal/?p=4', 0, 'post', '', 0),
(7, 1, '2021-04-05 13:27:06', '2021-04-05 13:27:06', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2021-04-11 08:50:57', '2021-04-11 08:50:57', '', 0, 'http://localhost/eveal/?page_id=7', 0, 'page', '', 0),
(8, 1, '2021-04-05 13:27:06', '2021-04-05 13:27:06', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 13:27:06', '2021-04-05 13:27:06', '', 7, 'http://localhost/eveal/?p=8', 0, 'revision', '', 0),
(9, 1, '2021-04-05 13:38:49', '2021-04-05 13:38:49', '', 'Installation Of WordPress', '', 'publish', 'open', 'open', '', 'installation-of-wordpress', '', '', '2021-04-05 13:38:52', '2021-04-05 13:38:52', '', 0, 'http://localhost/eveal/?p=9', 0, 'post', '', 0),
(10, 1, '2021-04-05 13:38:49', '2021-04-05 13:38:49', '', 'Installation Of Wordpress', '', 'inherit', 'closed', 'closed', '', '9-revision-v1', '', '', '2021-04-05 13:38:49', '2021-04-05 13:38:49', '', 9, 'http://localhost/eveal/?p=10', 0, 'revision', '', 0),
(11, 1, '2021-04-05 13:38:52', '2021-04-05 13:38:52', '', 'Installation Of WordPress', '', 'inherit', 'closed', 'closed', '', '9-revision-v1', '', '', '2021-04-05 13:38:52', '2021-04-05 13:38:52', '', 9, 'http://localhost/eveal/?p=11', 0, 'revision', '', 0),
(12, 1, '2021-04-05 14:27:41', '2021-04-05 14:27:41', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:4:\"page\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Page Fields', 'page-fields', 'publish', 'closed', 'closed', '', 'group_606b1dbb1a32c', '', '', '2021-04-10 11:24:38', '2021-04-10 11:24:38', '', 0, 'http://localhost/eveal/?post_type=acf-field-group&#038;p=12', 0, 'acf-field-group', '', 0),
(13, 1, '2021-04-05 14:27:41', '2021-04-05 14:27:41', 'a:7:{s:4:\"type\";s:3:\"tab\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"placement\";s:3:\"top\";s:8:\"endpoint\";i:0;}', 'Hero Banner', 'hero_banner', 'publish', 'closed', 'closed', '', 'field_606b1dc95a8ce', '', '', '2021-04-05 14:27:41', '2021-04-05 14:27:41', '', 12, 'http://localhost/eveal/?post_type=acf-field&p=13', 0, 'acf-field', '', 0),
(14, 1, '2021-04-05 14:27:41', '2021-04-05 14:27:41', 'a:10:{s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"collapsed\";s:0:\"\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:0:\"\";}', 'Banner Slides', 'banner_slides', 'publish', 'closed', 'closed', '', 'field_606b1df75a8cf', '', '', '2021-04-08 11:22:19', '2021-04-08 11:22:19', '', 12, 'http://localhost/eveal/?post_type=acf-field&#038;p=14', 2, 'acf-field', '', 0),
(16, 1, '2021-04-05 14:57:16', '2021-04-05 14:57:16', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Slide Title', 'slide_title', 'publish', 'closed', 'closed', '', 'field_606b2506b18dc', '', '', '2021-04-05 15:07:21', '2021-04-05 15:07:21', '', 14, 'http://localhost/eveal/?post_type=acf-field&#038;p=16', 0, 'acf-field', '', 0),
(17, 1, '2021-04-05 14:57:16', '2021-04-05 14:57:16', 'a:10:{s:4:\"type\";s:8:\"textarea\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:4:\"rows\";s:0:\"\";s:9:\"new_lines\";s:0:\"\";}', 'Slide Description', 'slide_description', 'publish', 'closed', 'closed', '', 'field_606b2515b18dd', '', '', '2021-04-10 11:24:38', '2021-04-10 11:24:38', '', 14, 'http://localhost/eveal/?post_type=acf-field&#038;p=17', 1, 'acf-field', '', 0),
(18, 1, '2021-04-05 14:57:16', '2021-04-05 14:57:16', 'a:10:{s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"collapsed\";s:0:\"\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:0:\"\";}', 'Slide CTAs', 'slide_ctas', 'publish', 'closed', 'closed', '', 'field_606b251bb18de', '', '', '2021-04-05 15:07:21', '2021-04-05 15:07:21', '', 14, 'http://localhost/eveal/?post_type=acf-field&#038;p=18', 2, 'acf-field', '', 0),
(19, 1, '2021-04-05 14:57:16', '2021-04-05 14:57:16', 'a:6:{s:4:\"type\";s:4:\"link\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:5:\"array\";}', 'CTA Item', 'cta_item', 'publish', 'closed', 'closed', '', 'field_606b2534b18df', '', '', '2021-04-05 14:57:16', '2021-04-05 14:57:16', '', 18, 'http://localhost/eveal/?post_type=acf-field&p=19', 0, 'acf-field', '', 0),
(20, 1, '2021-04-05 14:59:20', '2021-04-05 14:59:20', 'a:15:{s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:5:\"array\";s:12:\"preview_size\";s:6:\"medium\";s:7:\"library\";s:3:\"all\";s:9:\"min_width\";s:0:\"\";s:10:\"min_height\";s:0:\"\";s:8:\"min_size\";s:0:\"\";s:9:\"max_width\";s:0:\"\";s:10:\"max_height\";s:0:\"\";s:8:\"max_size\";s:0:\"\";s:10:\"mime_types\";s:0:\"\";}', 'Slide Image', 'slide_image', 'publish', 'closed', 'closed', '', 'field_606b2572cf56c', '', '', '2021-04-05 15:07:21', '2021-04-05 15:07:21', '', 14, 'http://localhost/eveal/?post_type=acf-field&#038;p=20', 3, 'acf-field', '', 0),
(22, 1, '2021-04-05 15:01:26', '2021-04-05 15:01:26', '', 'banner', '', 'inherit', 'open', 'closed', '', 'banner', '', '', '2021-04-05 15:01:26', '2021-04-05 15:01:26', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/banner.jpg', 0, 'attachment', 'image/jpeg', 0),
(23, 1, '2021-04-05 15:01:34', '2021-04-05 15:01:34', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:01:34', '2021-04-05 15:01:34', '', 7, 'http://localhost/eveal/?p=23', 0, 'revision', '', 0),
(24, 1, '2021-04-05 15:03:17', '2021-04-05 15:03:17', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:03:17', '2021-04-05 15:03:17', '', 7, 'http://localhost/eveal/?p=24', 0, 'revision', '', 0),
(25, 1, '2021-04-05 15:03:48', '2021-04-05 15:03:48', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:03:48', '2021-04-05 15:03:48', '', 7, 'http://localhost/eveal/?p=25', 0, 'revision', '', 0),
(26, 1, '2021-04-05 15:04:34', '2021-04-05 15:04:34', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:04:34', '2021-04-05 15:04:34', '', 7, 'http://localhost/eveal/?p=26', 0, 'revision', '', 0),
(27, 1, '2021-04-05 15:07:39', '2021-04-05 15:07:39', '', 'banner2', '', 'inherit', 'open', 'closed', '', 'banner2', '', '', '2021-04-05 15:07:39', '2021-04-05 15:07:39', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/banner2.mp4', 0, 'attachment', 'video/mp4', 0),
(28, 1, '2021-04-05 15:07:50', '2021-04-05 15:07:50', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:07:50', '2021-04-05 15:07:50', '', 7, 'http://localhost/eveal/?p=28', 0, 'revision', '', 0),
(29, 1, '2021-04-05 15:08:09', '2021-04-05 15:08:09', '', 'banner3', '', 'inherit', 'open', 'closed', '', 'banner3', '', '', '2021-04-05 15:20:51', '2021-04-05 15:20:51', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/banner3.jpg', 0, 'attachment', 'image/jpeg', 0),
(30, 1, '2021-04-05 15:08:14', '2021-04-05 15:08:14', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 15:08:14', '2021-04-05 15:08:14', '', 7, 'http://localhost/eveal/?p=30', 0, 'revision', '', 0),
(31, 1, '2021-04-05 16:15:48', '2021-04-05 16:15:48', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:4:\"page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:1:\"7\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Home Page', 'home-page', 'publish', 'closed', 'closed', '', 'group_606b3756837c7', '', '', '2021-04-05 16:29:42', '2021-04-05 16:29:42', '', 0, 'http://localhost/eveal/?post_type=acf-field-group&#038;p=31', 0, 'acf-field-group', '', 0),
(32, 1, '2021-04-05 16:15:48', '2021-04-05 16:15:48', 'a:7:{s:4:\"type\";s:3:\"tab\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"placement\";s:3:\"top\";s:8:\"endpoint\";i:0;}', 'About Section', 'about_section', 'publish', 'closed', 'closed', '', 'field_606b37638d9ec', '', '', '2021-04-05 16:15:48', '2021-04-05 16:15:48', '', 31, 'http://localhost/eveal/?post_type=acf-field&p=32', 0, 'acf-field', '', 0),
(33, 1, '2021-04-05 16:15:48', '2021-04-05 16:15:48', 'a:15:{s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:5:\"array\";s:12:\"preview_size\";s:6:\"medium\";s:7:\"library\";s:3:\"all\";s:9:\"min_width\";s:0:\"\";s:10:\"min_height\";s:0:\"\";s:8:\"min_size\";s:0:\"\";s:9:\"max_width\";s:0:\"\";s:10:\"max_height\";s:0:\"\";s:8:\"max_size\";s:0:\"\";s:10:\"mime_types\";s:0:\"\";}', 'About Image', 'about_image', 'publish', 'closed', 'closed', '', 'field_606b37798d9ed', '', '', '2021-04-05 16:15:48', '2021-04-05 16:15:48', '', 31, 'http://localhost/eveal/?post_type=acf-field&p=33', 1, 'acf-field', '', 0),
(34, 1, '2021-04-05 16:15:55', '2021-04-05 16:15:55', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 16:15:55', '2021-04-05 16:15:55', '', 7, 'http://localhost/eveal/?p=34', 0, 'revision', '', 0),
(35, 1, '2021-04-05 16:16:20', '2021-04-05 16:16:20', '', 'surfing', '', 'inherit', 'open', 'closed', '', 'surfing', '', '', '2021-04-05 16:16:20', '2021-04-05 16:16:20', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/surfing.jpg', 0, 'attachment', 'image/jpeg', 0),
(36, 1, '2021-04-05 16:16:25', '2021-04-05 16:16:25', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 16:16:25', '2021-04-05 16:16:25', '', 7, 'http://localhost/eveal/?p=36', 0, 'revision', '', 0),
(37, 1, '2021-04-05 16:29:41', '2021-04-05 16:29:41', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:2:\"50\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'About Section Heading', 'about_section_heading', 'publish', 'closed', 'closed', '', 'field_606b3a831710c', '', '', '2021-04-05 16:29:41', '2021-04-05 16:29:41', '', 31, 'http://localhost/eveal/?post_type=acf-field&p=37', 2, 'acf-field', '', 0),
(38, 1, '2021-04-05 16:29:42', '2021-04-05 16:29:42', 'a:10:{s:4:\"type\";s:8:\"textarea\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:2:\"50\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:4:\"rows\";s:0:\"\";s:9:\"new_lines\";s:0:\"\";}', 'About Section Description', 'about_section_description', 'publish', 'closed', 'closed', '', 'field_606b3a901710d', '', '', '2021-04-05 16:29:42', '2021-04-05 16:29:42', '', 31, 'http://localhost/eveal/?post_type=acf-field&p=38', 3, 'acf-field', '', 0),
(39, 1, '2021-04-05 16:30:19', '2021-04-05 16:30:19', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-05 16:30:19', '2021-04-05 16:30:19', '', 7, 'http://localhost/eveal/?p=39', 0, 'revision', '', 0),
(40, 1, '2021-04-08 06:02:54', '2021-04-08 06:02:54', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-08 06:02:54', '2021-04-08 06:02:54', '', 7, 'http://localhost/eveal/?p=40', 0, 'revision', '', 0),
(41, 1, '2021-04-08 11:22:19', '2021-04-08 11:22:19', 'a:13:{s:4:\"type\";s:6:\"select\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:1;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:7:\"choices\";a:4:{s:10:\"arrow-only\";s:21:\"With Arrow Navigation\";s:9:\"dots-only\";s:20:\"With Dots Pagination\";s:10:\"arrow-dots\";s:36:\"With Arrow Navigation And Pagination\";s:13:\"no-navigation\";s:39:\"Without Arrow Navigation And Pagination\";}s:13:\"default_value\";b:0;s:10:\"allow_null\";i:0;s:8:\"multiple\";i:0;s:2:\"ui\";i:0;s:13:\"return_format\";s:5:\"value\";s:4:\"ajax\";i:0;s:11:\"placeholder\";s:0:\"\";}', 'Slider Style', 'slider_style', 'publish', 'closed', 'closed', '', 'field_606ee66719776', '', '', '2021-04-08 11:22:19', '2021-04-08 11:22:19', '', 12, 'http://localhost/eveal/?post_type=acf-field&p=41', 1, 'acf-field', '', 0),
(42, 1, '2021-04-08 11:28:46', '2021-04-08 11:28:46', '<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like piña coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://localhost/eveal/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:28:46', '2021-04-08 11:28:46', '', 2, 'http://localhost/eveal/?p=42', 0, 'revision', '', 0),
(43, 1, '2021-04-08 11:28:52', '2021-04-08 11:28:52', '', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:28:52', '2021-04-08 11:28:52', '', 2, 'http://localhost/eveal/?p=43', 0, 'revision', '', 0),
(44, 1, '2021-04-08 11:30:31', '2021-04-08 11:30:31', '', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:30:31', '2021-04-08 11:30:31', '', 2, 'http://localhost/eveal/?p=44', 0, 'revision', '', 0),
(45, 1, '2021-04-08 11:30:47', '2021-04-08 11:30:47', '', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:30:47', '2021-04-08 11:30:47', '', 2, 'http://localhost/eveal/?p=45', 0, 'revision', '', 0),
(46, 1, '2021-04-08 11:33:38', '2021-04-08 11:33:38', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:33:38', '2021-04-08 11:33:38', '', 2, 'http://localhost/eveal/?p=46', 0, 'revision', '', 0),
(47, 1, '2021-04-08 11:33:38', '2021-04-08 11:33:38', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'About', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-04-08 11:33:38', '2021-04-08 11:33:38', '', 2, 'http://localhost/eveal/?p=47', 0, 'revision', '', 0),
(48, 1, '2021-04-08 11:38:35', '2021-04-08 11:38:35', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item2', '', 'publish', 'open', 'open', '', 'post-item2', '', '', '2021-04-08 11:39:47', '2021-04-08 11:39:47', '', 0, 'http://localhost/eveal/?p=48', 0, 'post', '', 0),
(49, 1, '2021-04-08 11:38:35', '2021-04-08 11:38:35', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item2', '', 'inherit', 'closed', 'closed', '', '48-revision-v1', '', '', '2021-04-08 11:38:35', '2021-04-08 11:38:35', '', 48, 'http://localhost/eveal/?p=49', 0, 'revision', '', 0),
(50, 1, '2021-04-08 11:39:23', '2021-04-08 11:39:23', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item2', '', 'inherit', 'closed', 'closed', '', '48-autosave-v1', '', '', '2021-04-08 11:39:23', '2021-04-08 11:39:23', '', 48, 'http://localhost/eveal/?p=50', 0, 'revision', '', 0),
(51, 1, '2021-04-08 12:02:01', '2021-04-08 12:02:01', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item3', '', 'publish', 'open', 'open', '', 'post-item3', '', '', '2021-04-08 12:27:02', '2021-04-08 12:27:02', '', 0, 'http://localhost/eveal/?p=51', 0, 'post', '', 0),
(52, 1, '2021-04-08 12:02:10', '2021-04-08 12:02:10', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item3', '', 'inherit', 'closed', 'closed', '', '51-revision-v1', '', '', '2021-04-08 12:02:10', '2021-04-08 12:02:10', '', 51, 'http://localhost/eveal/?p=52', 0, 'revision', '', 0),
(53, 1, '2021-04-08 12:02:17', '2021-04-08 12:02:17', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item4', '', 'publish', 'open', 'open', '', 'post-item4', '', '', '2021-04-08 12:02:26', '2021-04-08 12:02:26', '', 0, 'http://localhost/eveal/?p=53', 0, 'post', '', 0),
(54, 1, '2021-04-08 12:02:26', '2021-04-08 12:02:26', '<!-- wp:heading -->\n<h2>What is Lorem Ipsum?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<!-- /wp:paragraph -->', 'Post Item4', '', 'inherit', 'closed', 'closed', '', '53-revision-v1', '', '', '2021-04-08 12:02:26', '2021-04-08 12:02:26', '', 53, 'http://localhost/eveal/?p=54', 0, 'revision', '', 0),
(56, 1, '2021-04-10 05:13:45', '2021-04-10 05:13:45', '', 'logo-stjulien@2x', '', 'inherit', 'open', 'closed', '', 'logo-stjulien2x', '', '', '2021-04-10 05:13:45', '2021-04-10 05:13:45', '', 0, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-stjulien@2x.png', 0, 'attachment', 'image/png', 0),
(57, 1, '2021-04-10 05:14:15', '2021-04-10 05:14:15', '{\n    \"blogdescription\": {\n        \"value\": \"Digital Agency\",\n        \"type\": \"option\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 05:14:15\"\n    },\n    \"eve::custom_logo\": {\n        \"value\": 56,\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 05:14:15\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '52567ad0-308a-48ff-bd81-79a0a88e8826', '', '', '2021-04-10 05:14:15', '2021-04-10 05:14:15', '', 0, 'http://localhost/eveal/2021/04/10/52567ad0-308a-48ff-bd81-79a0a88e8826/', 0, 'customize_changeset', '', 0),
(58, 1, '2021-04-10 05:14:26', '2021-04-10 05:14:26', '', 'logo-treslatin@2x', '', 'inherit', 'open', 'closed', '', 'logo-treslatin2x', '', '', '2021-04-10 05:14:42', '2021-04-10 05:14:42', '', 0, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-treslatin@2x.png', 0, 'attachment', 'image/png', 0),
(59, 1, '2021-04-10 05:14:58', '2021-04-10 05:14:58', '{\n    \"site_icon\": {\n        \"value\": 58,\n        \"type\": \"option\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 05:14:58\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', 'dd5fcbaf-6fb9-4f10-890b-8b83140c0846', '', '', '2021-04-10 05:14:58', '2021-04-10 05:14:58', '', 0, 'http://localhost/eveal/2021/04/10/dd5fcbaf-6fb9-4f10-890b-8b83140c0846/', 0, 'customize_changeset', '', 0),
(60, 1, '2021-04-10 08:01:28', '2021-04-10 08:01:28', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 08:01:28', '2021-04-10 08:01:28', '', 7, 'http://localhost/eveal/?p=60', 0, 'revision', '', 0),
(61, 1, '2021-04-10 08:01:47', '2021-04-10 08:01:47', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 08:01:47', '2021-04-10 08:01:47', '', 7, 'http://localhost/eveal/?p=61', 0, 'revision', '', 0),
(62, 1, '2021-04-10 09:12:11', '2021-04-10 09:12:11', '[text* email-182 placeholder \"Your Name\"]\r\n[email* url-15 placeholder \"Your Email\"]\r\n<div>Date Of Birth : [date* textarea-498 placeholder \"Date of Birth\"]</div>\r\n<div>Select Option : [select* menu-741 include_blank \"Dropdown Item1\" \"Dropdown Item2\" \"Dropdown Item3\" \"Dropdown Item4\"]</div>\r\n[textarea* menu-875 placeholder \"Message\"]\r\n[checkbox* checkbox-828 use_label_element \"I do Agree With Terms and Conditions.\"]\r\n[submit]\n1\n\n[_site_title] <patel.truptesh1996@gmail.com>\n[_site_admin_email]\n\n\n\n\n\n\n[_site_title] \"[your-subject]\"\n[_site_title] <patel.truptesh1996@gmail.com>\n[your-email]\nMessage Body:\r\n[your-message]\r\n\r\n-- \r\nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\nReply-To: [_site_admin_email]\n\n\n\nThank you for your message. It has been sent.\nThere was an error trying to send your message. Please try again later.\nOne or more fields have an error. Please check and try again.\nThere was an error trying to send your message. Please try again later.\nYou must accept the terms and conditions before sending your message.\nThe field is required.\nThe field is too long.\nThe field is too short.\nThere was an unknown error uploading the file.\nYou are not allowed to upload files of this type.\nThe file is too big.\nThere was an error uploading the file.\nThe date format is incorrect.\nThe date is before the earliest one allowed.\nThe date is after the latest one allowed.\nThe number format is invalid.\nThe number is smaller than the minimum allowed.\nThe number is larger than the maximum allowed.\nThe answer to the quiz is incorrect.\nThe e-mail address entered is invalid.\nThe URL is invalid.\nThe telephone number is invalid.', 'Contact form', '', 'publish', 'closed', 'closed', '', 'contact-form-1', '', '', '2021-04-11 07:38:04', '2021-04-11 07:38:04', '', 0, 'http://localhost/eveal/?post_type=wpcf7_contact_form&#038;p=62', 0, 'wpcf7_contact_form', '', 0),
(63, 1, '2021-04-10 09:12:20', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2021-04-10 09:12:20', '0000-00-00 00:00:00', '', 0, 'http://localhost/eveal/?post_type=acf-field-group&p=63', 0, 'acf-field-group', '', 0),
(64, 1, '2021-04-10 09:13:28', '2021-04-10 09:13:28', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:12:\"options_page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:18:\"acf-options-footer\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Footer Fields', 'footer-fields', 'publish', 'closed', 'closed', '', 'group_60716bfa45814', '', '', '2021-04-10 09:17:21', '2021-04-10 09:17:21', '', 0, 'http://localhost/eveal/?post_type=acf-field-group&#038;p=64', 0, 'acf-field-group', '', 0),
(65, 1, '2021-04-10 09:13:28', '2021-04-10 09:13:28', 'a:7:{s:4:\"type\";s:3:\"tab\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"placement\";s:3:\"top\";s:8:\"endpoint\";i:0;}', 'Footer Code Blocks', '', 'publish', 'closed', 'closed', '', 'field_60716c0f2024a', '', '', '2021-04-10 09:13:28', '2021-04-10 09:13:28', '', 64, 'http://localhost/eveal/?post_type=acf-field&p=65', 0, 'acf-field', '', 0),
(66, 1, '2021-04-10 09:13:28', '2021-04-10 09:13:28', 'a:10:{s:4:\"type\";s:8:\"textarea\";s:12:\"instructions\";s:49:\"This Script Will Be Added Before End Of Body Tag.\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:4:\"rows\";i:30;s:9:\"new_lines\";s:0:\"\";}', 'Footer Script', 'footer_script', 'publish', 'closed', 'closed', '', 'field_60716c322024b', '', '', '2021-04-10 09:17:21', '2021-04-10 09:17:21', '', 64, 'http://localhost/eveal/?post_type=acf-field&#038;p=66', 1, 'acf-field', '', 0),
(67, 1, '2021-04-10 09:14:17', '2021-04-10 09:14:17', 'a:7:{s:4:\"type\";s:3:\"tab\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"placement\";s:3:\"top\";s:8:\"endpoint\";i:0;}', 'Copyright Section', 'copyright_section', 'publish', 'closed', 'closed', '', 'field_60716c3bb87da', '', '', '2021-04-10 09:14:17', '2021-04-10 09:14:17', '', 64, 'http://localhost/eveal/?post_type=acf-field&p=67', 2, 'acf-field', '', 0),
(68, 1, '2021-04-10 09:14:17', '2021-04-10 09:14:17', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Copyright Text', 'copyright_text', 'publish', 'closed', 'closed', '', 'field_60716c62b87db', '', '', '2021-04-10 09:14:17', '2021-04-10 09:14:17', '', 64, 'http://localhost/eveal/?post_type=acf-field&p=68', 3, 'acf-field', '', 0),
(69, 1, '2021-04-10 11:12:00', '2021-04-10 11:12:00', '', 'Get In Touch', '', 'publish', 'closed', 'closed', '', 'contact-us', '', '', '2021-04-11 06:20:11', '2021-04-11 06:20:11', '', 0, 'http://localhost/eveal/?page_id=69', 0, 'page', '', 0),
(70, 1, '2021-04-10 11:12:00', '2021-04-10 11:12:00', '', 'Contact Us', '', 'inherit', 'closed', 'closed', '', '69-revision-v1', '', '', '2021-04-10 11:12:00', '2021-04-10 11:12:00', '', 69, 'http://localhost/eveal/?p=70', 0, 'revision', '', 0),
(71, 1, '2021-04-10 11:19:37', '2021-04-10 11:19:37', '{\n    \"eve::nav_menu_locations[menu-1]\": {\n        \"value\": -7376501049324593000,\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 11:19:37\"\n    },\n    \"nav_menu[-7376501049324593000]\": {\n        \"value\": {\n            \"name\": \"Site Menu\",\n            \"description\": \"\",\n            \"parent\": 0,\n            \"auto_add\": false\n        },\n        \"type\": \"nav_menu\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 11:19:37\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', 'c021d8de-fa75-43e1-a9a9-932eb0a818ec', '', '', '2021-04-10 11:19:37', '2021-04-10 11:19:37', '', 0, 'http://localhost/eveal/2021/04/10/c021d8de-fa75-43e1-a9a9-932eb0a818ec/', 0, 'customize_changeset', '', 0),
(72, 1, '2021-04-10 11:19:50', '2021-04-10 11:19:50', '{\n    \"nav_menu_item[-6727310548127582000]\": {\n        \"value\": {\n            \"object_id\": 2,\n            \"object\": \"page\",\n            \"menu_item_parent\": 0,\n            \"position\": 1,\n            \"type\": \"post_type\",\n            \"title\": \"About\",\n            \"url\": \"http://localhost/eveal/about/\",\n            \"target\": \"\",\n            \"attr_title\": \"\",\n            \"description\": \"\",\n            \"classes\": \"\",\n            \"xfn\": \"\",\n            \"status\": \"publish\",\n            \"original_title\": \"About\",\n            \"nav_menu_term_id\": 8,\n            \"_invalid\": false,\n            \"type_label\": \"Page\"\n        },\n        \"type\": \"nav_menu_item\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 11:19:50\"\n    },\n    \"nav_menu_item[-5697599714968232000]\": {\n        \"value\": {\n            \"object_id\": 69,\n            \"object\": \"page\",\n            \"menu_item_parent\": 0,\n            \"position\": 2,\n            \"type\": \"post_type\",\n            \"title\": \"Contact Us\",\n            \"url\": \"http://localhost/eveal/contact-us/\",\n            \"target\": \"\",\n            \"attr_title\": \"\",\n            \"description\": \"\",\n            \"classes\": \"\",\n            \"xfn\": \"\",\n            \"status\": \"publish\",\n            \"original_title\": \"Contact Us\",\n            \"nav_menu_term_id\": 8,\n            \"_invalid\": false,\n            \"type_label\": \"Page\"\n        },\n        \"type\": \"nav_menu_item\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-04-10 11:19:50\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', 'ecb07eea-7eab-48c0-934c-9c59b1f1f5d4', '', '', '2021-04-10 11:19:50', '2021-04-10 11:19:50', '', 0, 'http://localhost/eveal/2021/04/10/ecb07eea-7eab-48c0-934c-9c59b1f1f5d4/', 0, 'customize_changeset', '', 0),
(73, 1, '2021-04-10 11:19:50', '2021-04-10 11:19:50', ' ', '', '', 'publish', 'closed', 'closed', '', '73', '', '', '2021-04-10 11:19:50', '2021-04-10 11:19:50', '', 0, 'http://localhost/eveal/2021/04/10/73/', 1, 'nav_menu_item', '', 0),
(74, 1, '2021-04-10 11:19:50', '2021-04-10 11:19:50', ' ', '', '', 'publish', 'closed', 'closed', '', '74', '', '', '2021-04-10 11:19:50', '2021-04-10 11:19:50', '', 0, 'http://localhost/eveal/2021/04/10/74/', 2, 'nav_menu_item', '', 0),
(75, 1, '2021-04-10 11:25:07', '2021-04-10 11:25:07', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 11:25:07', '2021-04-10 11:25:07', '', 7, 'http://localhost/eveal/?p=75', 0, 'revision', '', 0),
(76, 1, '2021-04-10 11:52:59', '2021-04-10 11:52:59', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 11:52:59', '2021-04-10 11:52:59', '', 7, 'http://localhost/eveal/?p=76', 0, 'revision', '', 0),
(77, 1, '2021-04-10 11:53:49', '2021-04-10 11:53:49', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 11:53:49', '2021-04-10 11:53:49', '', 7, 'http://localhost/eveal/?p=77', 0, 'revision', '', 0),
(78, 1, '2021-04-10 12:22:21', '2021-04-10 12:22:21', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-10 12:22:21', '2021-04-10 12:22:21', '', 7, 'http://localhost/eveal/?p=78', 0, 'revision', '', 0),
(79, 1, '2021-04-11 05:27:40', '2021-04-11 05:27:40', '', 'logo-baileys@2x', '', 'inherit', 'open', 'closed', '', 'logo-baileys2x', '', '', '2021-04-11 05:27:40', '2021-04-11 05:27:40', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-baileys@2x.png', 0, 'attachment', 'image/png', 0),
(80, 1, '2021-04-11 05:27:41', '2021-04-11 05:27:41', '', 'logo-breckbrewery@2x', '', 'inherit', 'open', 'closed', '', 'logo-breckbrewery2x', '', '', '2021-04-11 05:27:41', '2021-04-11 05:27:41', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-breckbrewery@2x.png', 0, 'attachment', 'image/png', 0),
(81, 1, '2021-04-11 05:27:41', '2021-04-11 05:27:41', '', 'logo-dali@2x', '', 'inherit', 'open', 'closed', '', 'logo-dali2x', '', '', '2021-04-11 05:27:41', '2021-04-11 05:27:41', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-dali@2x.png', 0, 'attachment', 'image/png', 0),
(82, 1, '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 'logo-delight@2x', '', 'inherit', 'open', 'closed', '', 'logo-delight2x', '', '', '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-delight@2x.png', 0, 'attachment', 'image/png', 0),
(83, 1, '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 'logo-dmns@2x', '', 'inherit', 'open', 'closed', '', 'logo-dmns2x', '', '', '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-dmns@2x.png', 0, 'attachment', 'image/png', 0),
(84, 1, '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 'logo-dunkin@2x', '', 'inherit', 'open', 'closed', '', 'logo-dunkin2x', '', '', '2021-04-11 05:27:42', '2021-04-11 05:27:42', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-dunkin@2x.png', 0, 'attachment', 'image/png', 0),
(85, 1, '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 'logo-honesttogoodness@2x', '', 'inherit', 'open', 'closed', '', 'logo-honesttogoodness2x', '', '', '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-honesttogoodness@2x.png', 0, 'attachment', 'image/png', 0),
(86, 1, '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 'logo-horizon@2x', '', 'inherit', 'open', 'closed', '', 'logo-horizon2x', '', '', '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-horizon@2x.png', 0, 'attachment', 'image/png', 0),
(87, 1, '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 'logo-min@2x', '', 'inherit', 'open', 'closed', '', 'logo-min2x', '', '', '2021-04-11 05:27:43', '2021-04-11 05:27:43', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-min@2x.png', 0, 'attachment', 'image/png', 0),
(88, 1, '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 'logo-oikos@2x', '', 'inherit', 'open', 'closed', '', 'logo-oikos2x', '', '', '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-oikos@2x.png', 0, 'attachment', 'image/png', 0),
(89, 1, '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 'logo-panasonic@2x', '', 'inherit', 'open', 'closed', '', 'logo-panasonic2x', '', '', '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-panasonic@2x.png', 0, 'attachment', 'image/png', 0),
(90, 1, '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 'logo-rad@2x', '', 'inherit', 'open', 'closed', '', 'logo-rad2x', '', '', '2021-04-11 05:27:44', '2021-04-11 05:27:44', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-rad@2x.png', 0, 'attachment', 'image/png', 0),
(91, 1, '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 'logo-silk@2x', '', 'inherit', 'open', 'closed', '', 'logo-silk2x', '', '', '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-silk@2x.png', 0, 'attachment', 'image/png', 0),
(92, 1, '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 'logo-stjulien@2x', '', 'inherit', 'open', 'closed', '', 'logo-stjulien2x-2', '', '', '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-stjulien@2x-1.png', 0, 'attachment', 'image/png', 0),
(93, 1, '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 'logo-stok@2x', '', 'inherit', 'open', 'closed', '', 'logo-stok2x', '', '', '2021-04-11 05:27:45', '2021-04-11 05:27:45', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-stok@2x.png', 0, 'attachment', 'image/png', 0),
(94, 1, '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 'logo-tervis@2x', '', 'inherit', 'open', 'closed', '', 'logo-tervis2x', '', '', '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-tervis@2x.png', 0, 'attachment', 'image/png', 0),
(95, 1, '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 'logo-treslatin@2x', '', 'inherit', 'open', 'closed', '', 'logo-treslatin2x-2', '', '', '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-treslatin@2x-1.png', 0, 'attachment', 'image/png', 0),
(96, 1, '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 'logo-trimble@2x', '', 'inherit', 'open', 'closed', '', 'logo-trimble2x', '', '', '2021-04-11 05:27:46', '2021-04-11 05:27:46', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-trimble@2x.png', 0, 'attachment', 'image/png', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(97, 1, '2021-04-11 05:27:47', '2021-04-11 05:27:47', '', 'logo-wildmade@2x', '', 'inherit', 'open', 'closed', '', 'logo-wildmade2x', '', '', '2021-04-11 05:27:47', '2021-04-11 05:27:47', '', 7, 'http://localhost/eveal/wp-content/uploads/2021/04/logo-wildmade@2x.png', 0, 'attachment', 'image/png', 0),
(99, 1, '2021-04-11 05:28:16', '2021-04-11 05:28:16', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-11 05:28:16', '2021-04-11 05:28:16', '', 7, 'http://localhost/eveal/?p=99', 0, 'revision', '', 0),
(100, 1, '2021-04-11 05:32:17', '2021-04-11 05:32:17', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-11 05:32:17', '2021-04-11 05:32:17', '', 7, 'http://localhost/eveal/?p=100', 0, 'revision', '', 0),
(101, 1, '2021-04-11 05:59:52', '2021-04-11 05:59:52', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-11 05:59:52', '2021-04-11 05:59:52', '', 7, 'http://localhost/eveal/?p=101', 0, 'revision', '', 0),
(102, 1, '2021-04-11 06:20:11', '2021-04-11 06:20:11', '', 'Get In Touch', '', 'inherit', 'closed', 'closed', '', '69-revision-v1', '', '', '2021-04-11 06:20:11', '2021-04-11 06:20:11', '', 69, 'http://localhost/eveal/?p=102', 0, 'revision', '', 0),
(103, 1, '2021-04-11 07:58:03', '2021-04-11 07:58:03', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:12:\"options_page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:22:\"acf-options-error-page\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'Theme Settings', 'theme-settings', 'publish', 'closed', 'closed', '', 'group_6072aadc921a0', '', '', '2021-04-11 07:59:27', '2021-04-11 07:59:27', '', 0, 'http://localhost/eveal/?post_type=acf-field-group&#038;p=103', 0, 'acf-field-group', '', 0),
(104, 1, '2021-04-11 07:58:03', '2021-04-11 07:58:03', 'a:7:{s:4:\"type\";s:3:\"tab\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"placement\";s:3:\"top\";s:8:\"endpoint\";i:0;}', 'Error Page', 'error_page', 'publish', 'closed', 'closed', '', 'field_6072aae969791', '', '', '2021-04-11 07:58:03', '2021-04-11 07:58:03', '', 103, 'http://localhost/eveal/?post_type=acf-field&p=104', 0, 'acf-field', '', 0),
(105, 1, '2021-04-11 07:58:03', '2021-04-11 07:58:03', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:22:\"The Page Not Found...!\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Error Text', 'error_text', 'publish', 'closed', 'closed', '', 'field_6072aaf969792', '', '', '2021-04-11 07:58:03', '2021-04-11 07:58:03', '', 103, 'http://localhost/eveal/?post_type=acf-field&p=105', 1, 'acf-field', '', 0),
(106, 1, '2021-04-11 07:58:03', '2021-04-11 07:58:03', 'a:10:{s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:9:\"collapsed\";s:0:\"\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:0:\"\";}', 'Error Page Quick Links', 'error_page_quick_links', 'publish', 'closed', 'closed', '', 'field_6072ab2a69793', '', '', '2021-04-11 07:58:03', '2021-04-11 07:58:03', '', 103, 'http://localhost/eveal/?post_type=acf-field&p=106', 2, 'acf-field', '', 0),
(107, 1, '2021-04-11 07:58:03', '2021-04-11 07:58:03', 'a:6:{s:4:\"type\";s:4:\"link\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:5:\"array\";}', 'Quick Link', 'quick_link', 'publish', 'closed', 'closed', '', 'field_6072ab4869794', '', '', '2021-04-11 07:58:03', '2021-04-11 07:58:03', '', 106, 'http://localhost/eveal/?post_type=acf-field&p=107', 0, 'acf-field', '', 0),
(108, 1, '2021-04-11 08:50:57', '2021-04-11 08:50:57', '', 'Home', '', 'inherit', 'closed', 'closed', '', '7-revision-v1', '', '', '2021-04-11 08:50:57', '2021-04-11 08:50:57', '', 7, 'http://localhost/eveal/?p=108', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(2, 'Tag Name1', 'tag-name1', 0),
(3, 'Tag Name2', 'tag-name2', 0),
(4, 'Tag3', 'tag3', 0),
(5, 'Tag Item', 'tag-item', 0),
(6, 'Category1', 'category1', 0),
(7, 'Category Name', 'category-name', 0),
(8, 'Site Menu', 'site-menu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(9, 1, 0),
(48, 2, 0),
(48, 3, 0),
(48, 4, 0),
(48, 5, 0),
(48, 6, 0),
(48, 7, 0),
(51, 2, 0),
(51, 3, 0),
(51, 4, 0),
(51, 5, 0),
(51, 6, 0),
(51, 7, 0),
(53, 1, 0),
(53, 2, 0),
(53, 3, 0),
(53, 4, 0),
(53, 5, 0),
(53, 6, 0),
(53, 7, 0),
(73, 8, 0),
(74, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 3),
(2, 2, 'post_tag', '', 0, 3),
(3, 3, 'post_tag', '', 0, 3),
(4, 4, 'post_tag', '', 0, 3),
(5, 5, 'post_tag', '', 0, 3),
(6, 6, 'category', '', 0, 3),
(7, 7, 'category', '', 0, 3),
(8, 8, 'nav_menu', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'trup1996'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:\"e3bf12c64bf037c733b00ff3b0b07132e05da6fefa1d6a9448d3dc6f35fd9c91\";a:4:{s:10:\"expiration\";i:1618838766;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36\";s:5:\"login\";i:1617629166;}}'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '4'),
(18, 1, 'wp_user-settings', 'libraryContent=browse'),
(19, 1, 'wp_user-settings-time', '1617634890'),
(20, 1, 'meta-box-order_', 'a:4:{s:6:\"normal\";s:47:\"acf-group_606b1dbb1a32c,acf-group_606b3756837c7\";s:15:\"acf_after_title\";s:0:\"\";s:4:\"side\";s:0:\"\";s:8:\"advanced\";s:0:\"\";}');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'trup1996', '$P$BFdrIcBVxpPyvnUXp64.M4pCXn/U991', 'trup1996', 'patel.truptesh1996@gmail.com', 'http://localhost/eveal', '2021-04-05 13:24:05', '', 0, 'trup1996');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;

--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
