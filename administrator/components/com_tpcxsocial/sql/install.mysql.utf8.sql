--
-- Structure de la table `#__tpcxsocial_forum_categories`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `access` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `published` int(11) NOT NULL,
  `visible` int(11) NOT NULL,
  `description` text NOT NULL,
  `images` text NOT NULL,
  `topic_ordering` varchar(255) NOT NULL,
  `topic_number` mediumint(9) NOT NULL,
  `post_number` mediumint(9) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_left_right` (`lft`,`rgt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

REPLACE INTO `joomla_tpcxsocial_forum_categories` (`id`, `parent_id`, `lft`, `rgt`, `level`, `title`, `alias`, `access`, `path`, `published`, `visible`, `description`, `images`, `topic_ordering`, `topic_number`, `post_number`, `created_by`, `modified_by`, `created`, `modified`) VALUES
(1, 0, 0, 17, 0, 'root', 'root', 1, '', 1, 0, '', '', '', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');


-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_forum_posts`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `published` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `rating` FLOAT(11) NOT NULL,
  `created_by_name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_forum_topics`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` tinytext NOT NULL,
  `description` TEXT NOT NULL,
  `alias` varchar(255) NOT NULL,
  `posts` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `thematique_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `locked` int(11) NOT NULL,
  `last_post_id` int(11) NOT NULL,
  `last_post_time` datetime NOT NULL,
  `last_post_user_id` int(11) NOT NULL,
  `last_post_message` text NOT NULL,
  `last_post_guest_name` tinytext NOT NULL,
  `created_by_name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_forum_topics_categories`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_topics_categories` (
  `topic_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_forum_topics_tags`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_topics_tags` (
  `topic_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_users`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `birthday` datetime NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `login_facebook` int(11) NOT NULL DEFAULT '0',
  `facebook_id` VARCHAR(255) NOT NULL,
  `login_google` int(11) NOT NULL DEFAULT '0',
  `posts` int(11) NOT NULL,
  `country_visited` varchar(255) NOT NULL,
  `country_last` varchar(255) NOT NULL,
  `quote` varchar(255) NOT NULL,
  `hobbies` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `profile` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_users_liked`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_users_liked` (
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__tpcxsocial_users_rating`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_users_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Structure de la table `#__tpcxsocial_forum_tags_categories`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_tags_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `published` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Structure de la table `#__tpcxsocial_forum_tags`
--

CREATE TABLE IF NOT EXISTS `#__tpcxsocial_forum_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `published` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
