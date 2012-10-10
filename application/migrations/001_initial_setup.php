<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * initial migration
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file 001_initial_setup.php
 */

/**
 * Migration_initial_setup class.
 * 
 * @extends MY_Migration
 */
class Migration_initial_setup extends MY_Migration
{
	// --------------------------------------------------------------------------
		
	/**
	 * up function.
	 * 
	 * @access public
	 * @return void
	 */
	public function up()
	{
		$query = "# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.27)
# Database: bookymark
# Generation Time: 2012-10-07 20:31:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table api_clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `api_clients`;

CREATE TABLE `api_clients` (
  `access_token` varchar(40) DEFAULT NULL,
  `shared_secret` varchar(40) DEFAULT NULL,
  `throttle_count` int(11) DEFAULT NULL,
  `throttled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `api_clients` WRITE;
/*!40000 ALTER TABLE `api_clients` DISABLE KEYS */;

INSERT INTO `api_clients` (`access_token`, `shared_secret`, `throttle_count`, `throttled_at`)
VALUES
	('4395dd07a3cfe84d9655bb2542907f3acd0024fe','3c697e1314808f56bd44bc5ccb4765607b433715',6,'2012-10-07 21:46:08');

/*!40000 ALTER TABLE `api_clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bookmarks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bookmarks`;

CREATE TABLE `bookmarks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(300) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `bookmarks` WRITE;
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;

INSERT INTO `bookmarks` (`id`, `url`, `description`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'http://yahoo.com','yay',0,NULL,NULL),
	(2,'http://yahoo.com','it\'s yahoo!',0,NULL,NULL),
	(3,'http://google.com','Google home page.',0,NULL,NULL),
	(6,'http://www.mallverkstan.se','Vår hemsida igen',0,NULL,NULL),
	(7,'www.google.com','fdsf',0,NULL,NULL),
	(8,'http://www.hipcalendar.com','Hip Calendar - Your local events',0,NULL,NULL),
	(9,'sada','asdasd',0,NULL,NULL),
	(10,'dasdasdasd','sdadas',0,NULL,NULL),
	(11,'http://bookymark.com/bookmarks/add_item?return_url=bookmarks/list_items','sadasdas',0,NULL,NULL),
	(12,'http://www.google.com','Google front page',0,NULL,NULL),
	(13,'hjk','kjhk',0,NULL,NULL),
	(14,'http://youtu.be/kyvaMxljntY','',0,NULL,NULL),
	(15,'http://youtu.be/ikPbkbTnUvQ','itak',0,NULL,NULL),
	(16,'www.istiadat.gov.my','ok',0,NULL,NULL),
	(17,'www.google.com','Google of course!',0,NULL,NULL),
	(18,'tesetett','setsfsdf',0,NULL,NULL),
	(19,NULL,'test55554444',0,NULL,NULL),
	(20,NULL,'test55554444',0,NULL,NULL),
	(21,NULL,'test55554444',0,NULL,NULL),
	(22,NULL,'test55554444',0,NULL,NULL),
	(26,'test123','t3et123',0,NULL,NULL),
	(27,'asdasdf','asdsdff',0,NULL,NULL),
	(28,'asasdasdasd','asdasdadasdasddas',0,NULL,NULL),
	(29,'dfsdfdsfdsdf','dfsfsd',0,NULL,NULL),
	(30,NULL,'TESTTEST123123',0,NULL,NULL),
	(31,'8888','8888',0,NULL,NULL),
	(32,'mmmmm','mmm',0,NULL,NULL),
	(33,'bbbb','bbbb',0,NULL,NULL),
	(34,'vvvv','vvvvv',0,NULL,NULL),
	(35,'kkkkkk','kkkkkk',0,NULL,NULL),
	(36,'http://yahoo.com','wahoo',83,NULL,NULL);

/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `home_page` varchar(100) DEFAULT NULL,
  `can_list_bookmarks` tinyint(1) DEFAULT '0',
  `can_view_bookmarks` tinyint(1) DEFAULT '0',
  `can_edit_bookmarks` tinyint(1) DEFAULT '0',
  `can_add_bookmarks` tinyint(1) DEFAULT '0',
  `can_delete_bookmarks` tinyint(1) DEFAULT '0',
  `can_migrate` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `title`, `home_page`, `can_list_bookmarks`, `can_view_bookmarks`, `can_edit_bookmarks`, `can_add_bookmarks`, `can_delete_bookmarks`, `can_migrate`, `created_at`, `updated_at`)
VALUES
	(1,'Superuser','bookmarks',1,1,1,1,1,1,NULL,NULL),
	(2,'User','bookmarks',1,1,1,1,1,0,NULL,NULL);

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `confirm_string` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `udpated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email_address`, `password`, `role_id`, `confirm_string`, `status`, `created_at`, `udpated_at`)
VALUES
	(45,'torino.raymon@gmail.com','QLbtpr5L043DLnopIt7HfCFgUbH0Ldi5Gs9znlte7JtctOVMWJLXykzMpDH7ngQu6b5c893bf7bd92376f6603f953a0013717f373b7b799adef945d5ba2953e6052',1,'EP15VDxdCwluNNa8WnnZ',NULL,NULL,NULL),
	(46,'torino.raymond@gmail.com','uP4AtdIvoclkYQrdC0YnGMxyAI0LuVzvf3qmGbHAjF5YsJNlcvbpFEqUmmiTDPl07413952ff761ff138d197d2b09e8bcbac889b9958badc8635cea66a30dc88d57',1,'',NULL,NULL,NULL),
	(47,'gps85@hotmail.com','SZz6glxm3B6nQ46EJiyVLZiOvS1uRdh809THbRbwYLBr2WZKmxz7WdAeecZBRewHe2550581e0ad5259a92ad5c9aaaf5f4458139a1c6d87830c1d07c5256163f5c0',1,'',NULL,NULL,NULL),
	(49,'sistemtek16@mynet.com','dyYJTQFvXJs511jAV8FdS05z5W2ythPUmXFfif34KzBDrPsVuySUsN5h0kdwQXqpad877ee1c75b05b0d63908ffd2ec1c9a5cdb15fb241d0ed76c74a41a3fd67ca3',1,'',NULL,NULL,NULL),
	(50,'rolf@mallverkstan.se','ycowjpT38DzjW7Oa3PDhdFyOjLeAGCobwawMFkvwTviI1zqMPxk2SpoqVt6ekcODe1a7a2694fb44135346a8ee38c3eb9b557639f32451fb8acd67f32797fb84d5d',1,'',NULL,NULL,NULL),
	(51,'test@testemail.com','cqzg1qE5ObFL3oNntSRCjPezUIVZSFOxpDaIATvseYtAaAJVE3k0VF939tZHtM9i8e45ff4b159eb026645a2e4ebb9a333e45d9107dfb849e8f80ff56e892b1c482',1,'2NzK4LQ846Qf2ML7QmfH',NULL,NULL,NULL),
	(52,'benpfohl@hotmail.com','eJDrjspFNMhsIBHsEqI4vDaHwxQVFlcVcF7GocPPAdprI2yRPJ4hlRndHTYgPVnpd91828857337b2f8c328fdf623794e493fb08776c322b15fd3abbc73039b78d5',1,'OQVGlbL8ufQtKLnjGUTJ',NULL,NULL,NULL),
	(53,'hur1can3@hotmail.com','LUPrIVcKaY1hbH34S4nXxwKQQMNERhHkFybzAHZxAR04teTqsB2ZWUZIBGu3Z9mr3ddfd2052d69b7d0310495d75b42e6106aa23b7bc1b280ca2781a02c67a893b6',1,'prgvgFjbXtz9zmceP8gD',NULL,NULL,NULL),
	(54,'levandowski.matthew@gmail.com','YDFhi4BTK3BzhKnctTxUDS4xuCklGw4Yx3AJrFiAdZcmAILbU5rVEp137cBCb6Slf0f06aeec3d113c2884d0d6910cc72c40fe58897ef88216b2533acf4a10e1d71',1,'',NULL,NULL,NULL),
	(55,'gajbica05@gmail.com','hgOfzHGPHyzCvLcICFOnd37UD703UHBLaAq1jEwKiHBelWXcwSaq6ajyiKWFqAft3b53c71cb6db273c87dce92a994589add8271ad504bfed582efcfda75b63dc83',1,'JaRFHEsz689azcJs7exp',NULL,NULL,NULL),
	(56,'rogerglenn@me.com','tvg8M3VanDDXPMymzNaQnc6oGHHoiZc2rg88UdyP1txidP6Ky4BMvre8AFlDk3J27dcf51bb86f8fb4e9186d20c51684020084cc3d2925897867b443846a6e8a56a',1,'',NULL,NULL,NULL),
	(57,'samanasrikanth@gmail.com','wKhgGHYLgdOYOOpzw7AGLolycsCkNJ6XY5i9fIwMwVu7zgbrxZ0RoS0rA8INrY6S0ec30bfc1af172f86c92c2227e2f0c6be116578ab95f4cf22727e1c80813f5a7',1,'',NULL,NULL,NULL),
	(58,'vikrantsharma1@gmail.com','tx7LoAtK9YwksAkbDK4jKThL0U29fXoi58LKV4MG29oUsbHMibwOp4Q7YSKULdrC8508e4d071a71b6651d31ab4e9357b00bbe4c7d496287c363e69a52d29de000a',1,'',NULL,NULL,NULL),
	(59,'bjorn.michelsen@gmail.com','X7qhbB8UpJPrCcnHMBqAdIonsEP7aob3nA2y1PKCQIKLuk8E0qD8EnNeVUL40vVcfce58f949dc47e5f7ff3c1eaf02e3da2b8629912f3ef497d28085217abff21cf',1,'',NULL,NULL,NULL),
	(60,'joe@me.com','NxDhp9qW4jnNNnaws4Ugc6e5p0q8TMXw7Sz0ZN2MoxRHRbhKP0uSXtig3ZBKaDNb98bdaa5a3bacb6a3cfed02faa61a6bffa39794e5766d4849894a82d216d1befd',1,'9BTdhJ23SSmlN97e3PEx',NULL,NULL,NULL),
	(61,'jokira247@gmail.com','qCPFBOb4wh1RIhRavDku3GlhtcK3nCGkvNu7x627rp1u3Dr7yxF6TgUBCaMmhVUn836da5b2203a99ad903e5bbe22602edcb7c294d1576a5cb0f6de679b006cd69b',1,'',NULL,NULL,NULL),
	(62,'samanasrikanth@gmail.com','H0FrJNmnYgrxETTZ3vbXdzJqCX6cN3VNJaWShPxB3F8qHMw1J4IU4PxZH1Ir02atf953a60e086c135e8797effebd5475a8d9f3487dd8be51af66fcb90b7e3e2671',1,'',NULL,NULL,NULL),
	(63,'ithoney051591@mailnesia.com','UWL62lqMvVOTDmTjxNc8yVfyL3HRmsO9fyjTizGzK7iflsJyzMXODPRSlqYLk32rd5bae254465bd29865c5e51ecbcc0eff39b99c5a7a2035ac633a2bac406fb692',1,'',NULL,NULL,NULL),
	(64,'tharshan09@gmail.com','9d6Yjt8CKrIJL1G3RwEEzylBPqr4u7wvNw5BD6HURt0IJDxzIKmcnrciG0VPfJL7f85691e03c7a7f7fc2834b5381440e693d621a71781ed519ee3b270773a8b4d6',1,'FkPVD6BMnpKRb4BQ438N',NULL,NULL,NULL),
	(65,'karthik.b@prystino.com','WE34Txz9nmshmqceHD0jDkDQty77M3CgEmYlxpF8rhIROVNMBea7jH03wHT9VkFPdd81273763d537ad92d86c121430995d36588117bfa6d347275481ab580f3bf5',1,'',NULL,NULL,NULL),
	(66,'mistedesign@gmail.com','BlXpcV7pTklCGBSGlc8c6BhiO0QVMZN76UW4iC6XjLOxaBHGF180wTLA5UEk7rPkfc3c1bb3d930a00052b9e5d373976143f4fb8fe4591b53c92faaa296628c8e2d',1,'',NULL,NULL,NULL),
	(67,'a@a.com','e5Rqr5zoJ7Ytf8ZGYEilt3shznB5OvJkVGlNoUtnKSToghh8YpQGUV0K3dSIEaC9f91b929990b526a4492e4a1e6f27490c7055375424e8cebedcab4e312875982f',1,'HT4oAlfb5vN1phLfdpEH',NULL,NULL,NULL),
	(68,'lesysteme@yahoo.com','rT20G90ciMimj9w0vULtrXk9k3oDGmEmH687JYqcTzmMRKkDRsjj07HJrduSZTAK968a9087f41090b1c0dd49ab0f7b0a33119c1ef29c7b16296791ea4cda6de2b1',1,'',NULL,NULL,NULL),
	(69,'testtest@test.com','R6IAT1KlOJN9YTkKUZgSkqp6EsvF6jyVjcQUtt1KKCoQbC2mJELOL3bW6XLWLAIEb4d8a61a162e64359c174ecc779ae6e3e9008dcfcd7464bdbf08dc4202067089',1,'AYCdNcqh1vW3TzaahchQ',NULL,NULL,NULL),
	(70,'test@test.com','647ykCniygLWaPL7mIxd7S8K6aCRMArtnacwMvx0dKkVScgeffbhQDrfl0wwe3Bc69d47bb9a802af0b198695249482a57bb2b5e98045a906da73acd72d5f86edbb',1,'F0xAZY1yAE1rOfZtvviy',NULL,NULL,NULL),
	(71,'deangwd@hotmail.co.uk','z8sr0JDcrFPOgpqI3LE5PouBGQMBFRNCU5hmOkmR98VRNcifhD9J81FYK6tdAAB4cbbf9f5c94538998f4c26eb36bc977f4ece379d15542d440e25b7e048100aace',1,'',NULL,NULL,NULL),
	(72,'deangwd@hotmail.co.uk','wmiXGDnzG7AREl3VeGOWr57Nf7lqBgvIO1WH80aSNT6DjZ1xZVCwO6np7o90v4fl2b107dbb1bb66c82b9a1b3d1f8b30031b7487309fc57ea33713b705bb6781f4e',1,'',NULL,NULL,NULL),
	(73,'deangwd@hotmail.co.uk','W4oUQyYEXPzX1AfM9YKhR9iLZqZktUS1Hkf45sTyG6DXkfxPhWn6roTcqEh6MlNId55be2cef67ee1719f70dee5fc0e03eff951443bdf0d1cfea3ecfbc97d613b02',1,'',NULL,NULL,NULL),
	(74,'matt@kafene.org','Up56hhxq77TYjIeR1cjLCDPtoctTbjbsUBkFhq7ZeJYpfKPs6A3Z7r529iCly3bm49366a47ad9722f04ee05ec7714750b97f4c283265ad429bb1b7b597e67f4b04',1,'',NULL,NULL,NULL),
	(75,'responsive.uk@gmail.com','8KYlZhLtQYBTKz795XRPHOgmjIPxLQUOFfjkIr1RKfUBrAnM5iGexDDwRjLdHTkV69255124b236b62960f91aa63fabe10e3c880f3b2b165b962887208ccc41035a',1,'',NULL,NULL,NULL),
	(76,'aidan@citylogic.co.za','7zUrfBYJ21OTnvxDyp7sgud01OWAKeqVPTMannfwd7NM4kspTarluyNcXPKKtQWec0b5b893dcf021f27ea141070a32d57248bfb2e6f45fce01b6968cca29134550',1,'',NULL,NULL,NULL),
	(77,'asf@asf.ngf','w3EeAfxCY0bDhj2mrNpXd8qsZAiSPy6JPAZYGxeT5IORDr1NdKY8CC79wudlS4WE0980f3cd146a122a9ee1f4a23a5ee61230f506f869debd314c36d314b28f4793',1,'LK8vR3lbOb88Dr8L3u1f',NULL,NULL,NULL),
	(78,'karthikud@gmail.com','kz9jWbx9dIRub4yYdJ0AE7NaIAFRLH2eFxRB4048OOdU3faHyNuJfNB1Ls9Axb4J4a3a9ef23f699270e8b07e86dcdd7ff23224321b30947ac2081bed0aa91eafd5',1,'',NULL,NULL,NULL),
	(79,'faizalamat@gmail.com','U9kDYYOyJFMy2Je7vepQrpnpx5B8bOXaqWGoUR0XksCv4bfSxhF2puIsU7xftbSjba8af3435436dad02b43f2236f702fcefbd1c9b400c498fad84bd4c88f73ebd1',1,'',NULL,NULL,NULL),
	(80,'dd@gmail.com','mOvpleRrIytOZz0Z6PuIvizhMmpdMRmh21JKGcLmjLbNhcS55S2aJnmJdyXgZqWy1411a16ce77e7a45988000aa06763a53088649dd7911a69ff74410c26c4733de',1,'jUmqwbK0jjYkoeTA9sw8',NULL,NULL,NULL),
	(81,'asd@asd.asd','JhhEhtUxkchvuJlywudxK139A9vY8hVNdAjuRU2enxqp3OIup9U76ZG15mTl8mCI2106f63c889d7553837bbb5eb4f20a73a80f8de00ce27a6476e1cb504da3aa92',1,'qp3pvh6Zwpbk9w7m8rl1',NULL,NULL,NULL),
	(82,'athleticartistry@hotmail.com','K8SAZ94ISWwSnrvK6LB8wJBWDk5taoARwkOGqTaH5AZEVqyG0x17kV7qG3kjXFDZb4c555ecedf35e69c22b117f5f6d38767fed81aa428e06efc47aa6a9d1581c4c',1,'',NULL,NULL,NULL),
	(83,'m.ikedfunk@gmail.com','Xk1I9h4a02JkHrSnUgp0DgMxWTBnLu8dKoC3gBIIFkP0jinXxJcmPfM6aEBzXo2df331fea19e6a192f4e17e86d422be6199eff02ee261946ec7ff4356897479b3f',1,'',NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
";
		$this->db->query($query);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * down function.
	 * 
	 * @access public
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table('api_clients');
		$this->dbforge->drop_table('bookmarks');
		$this->dbforge->drop_table('roles');
		$this->dbforge->drop_table('users');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file 001_initial_setup.php */
/* Location: ./applicatin/migrations/001_initial_setup.php */