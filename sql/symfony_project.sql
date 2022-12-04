-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 04 déc. 2022 à 20:58
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `symfony_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_published` tinyint(1) NOT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `created_at`, `updated_at`, `is_published`, `image`) VALUES
(2, 'La mode cocooning pour cet hiver 2022', 'Tootsie roll macaroon sesame snaps lemon drops tiramisu. Danish gingerbread cupcake bonbon carrot cake candy tart dragée dragée. Biscuit apple pie macaroon halvah powder topping dragée. Wafer chupa chups wafer lollipop wafer donut. Biscuit jelly toffee ice cream fruitcake pie donut sesame snaps jujubes. Apple pie cake dragée sesame snaps wafer toffee apple pie cake. Icing toffee powder dessert carrot cake lemon drops lollipop. Gummi bears ice cream tart dragée pudding pie marzipan cookie liquorice. Cake soufflé candy canes icing cupcake. Carrot cake jelly toffee sweet roll sweet chupa chups biscuit brownie gingerbread. Chocolate bar marzipan powder pastry topping. Jujubes chocolate bar marzipan shortbread sweet chocolate cake bonbon muffin jelly beans.', '2022-12-02 14:20:03', '2022-12-02 14:23:58', 0, NULL),
(3, 'Les beaux jours reviennent', 'Bonbon oat cake sugar plum muffin chocolate bar fruitcake cotton candy candy canes ice cream. Cookie cookie muffin bonbon marzipan tootsie roll. Liquorice muffin halvah candy canes shortbread pastry cheesecake. Bonbon cookie tart tiramisu pastry chocolate bar pastry sweet jelly. Brownie carrot cake chocolate bar powder candy chupa chups marshmallow caramels carrot cake. Gingerbread chocolate bar caramels topping lemon drops. Candy croissant brownie toffee tootsie roll apple pie icing lollipop jelly. Icing candy canes jelly-o shortbread chocolate bar shortbread. Sesame snaps chocolate bar macaroon halvah tootsie roll gummies. Danish shortbread apple pie apple pie sweet roll gingerbread dragée liquorice jujubes. Pastry macaroon chupa chups toffee lollipop sugar plum shortbread dessert ice cream. Pastry shortbread pie cookie halvah liquorice danish gingerbread. Muffin sweet roll bear claw sesame snaps caramels marzipan. Caramels cotton candy cake bear claw donut dragée candy', '2022-12-02 14:22:32', '2022-12-04 20:15:42', 1, NULL),
(6, 'La nouvelle tendance du printemps', 'Neutra chartreuse echo park palo santo, 3 wolf moon man bun iPhone JOMO selvage pop-up vibecession pork belly cardigan literally franzen. Photo booth keytar cronut, selfies lyft fam cold-pressed meditation vexillologist umami. Gentrify crucifix pitchfork pinterest mumblecore meggings vegan. La croix fashion axe vegan, VHS hexagon neutra before they sold out green juice selvage copper mug. no', '2022-12-04 20:15:32', '2022-12-04 20:20:28', 1, NULL),
(7, 'Les chaussures du futures : les chaussures à roulette', 'Meh flexitarian taiyaki keffiyeh, chillwave ramps hella distillery tote bag truffaut marfa hammock lo-fi stumptown. Put a bird on it pug twee tbh slow-carb vape VHS green juice crucifix tote bag umami. Irony artisan cred tonx readymade bicycle rights DSA Brooklyn pinterest vaporware waistcoat chartreuse art party poutine kickstarter. Helvetica synth cornhole messenger bag Brooklyn whatever twee.', '2022-12-04 20:16:29', NULL, 0, NULL),
(8, 'Pourquoi le simili-cuir va-t-il remplacer le cuir ?', 'Truffaut disrupt flexitarian unicorn blog, ramps fixie coloring book direct trade butcher jianbing man braid food truck. Occupy fit fam pour-over skateboard flannel. Selvage put a bird on it chia, asymmetrical tousled gastropub lyft trust fund organic direct trade mlkshk hella. Cliche austin hexagon vaporware man braid, jianbing tousled.', '2022-12-04 20:17:13', '2022-12-04 20:17:20', 1, NULL),
(9, 'Une mode vegan, éthique et accessible : est-ce possible ?', 'Neutra chartreuse echo park palo santo, 3 wolf moon man bun iPhone JOMO selvage pop-up vibecession pork belly cardigan literally franzen. Photo booth keytar cronut, selfies lyft fam cold-pressed meditation vexillologist umami. Gentrify crucifix pitchfork pinterest mumblecore meggings vegan. La croix fashion axe vegan, VHS hexagon neutra before they sold out green juice selvage copper mug.', '2022-12-04 20:18:10', NULL, 1, NULL),
(10, 'La fast-fashion : miroir d\'une société malade', 'DIY tonx chillwave before they sold out poutine. Godard big mood keytar, woke tofu semiotics blog af microdosing adaptogen tumeric waistcoat craft beer taxidermy. Waistcoat ennui swag vice irony leggings coloring book hell of authentic bodega boys kale chips. Cred unicorn vegan, air plant cloud bread vaporware jean shorts sartorial normcore. 8-bit kogi salvia cronut shoreditch freegan photo booth iPhone try-hard, DSA sus pork belly.', '2022-12-04 20:19:41', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `article_user`
--

DROP TABLE IF EXISTS `article_user`;
CREATE TABLE IF NOT EXISTS `article_user` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`user_id`),
  KEY `IDX_3DD151487294869C` (`article_id`),
  KEY `IDX_3DD15148A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_user`
--

INSERT INTO `article_user` (`article_id`, `user_id`) VALUES
(2, 5),
(2, 6),
(3, 5),
(3, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 5);

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BA388B77E3C61F9` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `owner_id`) VALUES
(6, 5),
(5, 6),
(1, 7),
(3, 8),
(2, 13),
(4, 18);

-- --------------------------------------------------------

--
-- Structure de la table `cart_product`
--

DROP TABLE IF EXISTS `cart_product`;
CREATE TABLE IF NOT EXISTS `cart_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2890CCAA4584665A` (`product_id`),
  KEY `IDX_2890CCAA1AD5CDBF` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cart_product`
--

INSERT INTO `cart_product` (`id`, `product_id`, `cart_id`, `color`, `quantity`) VALUES
(4, 2, 1, 'noir', 1),
(5, 3, 1, 'bleu marine', 1),
(6, 5, 1, 'gris clair', 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Chaussures'),
(2, 'T-shirt'),
(3, 'Chemises'),
(4, 'Robes'),
(5, 'Chaussettes');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `colors` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_published` tinyint(1) NOT NULL,
  `images` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD8DE820D9` (`seller_id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `seller_id`, `category_id`, `title`, `description`, `price`, `available_quantity`, `colors`, `created_at`, `updated_at`, `is_published`, `images`) VALUES
(2, 7, 1, 'Chaussures à paillettes', 'blablablabalbalbalabla', 120, 100, 'a:4:{i:0;s:4:\"noir\";i:1;s:5:\"blanc\";i:2;s:11:\"bleu marine\";i:3;s:10:\"gris clair\";}', '2022-12-04 17:53:44', NULL, 1, 'a:0:{}'),
(3, 8, 4, 'Robe de soirée à paillettes', 'Truffaut kinfolk big mood church-key, iPhone ramps bitters woke kogi. Truffaut readymade portland hot chicken offal pinterest selvage air plant green juice godard forage you probably haven\'t heard of them ascot. Locavore kale chips leggings, bespoke jean shorts scenester vibecession taiyaki seitan farm-to-table artisan tumblr church-key gastropub. Sus vibecession pok pok messenger bag cloud bread ugh, shabby chic pabst kale chips jianbing. Ascot direct trade enamel pin hammock. Iceland tote bag distillery whatever knausgaard wayfarers cold-pressed actually. Pinterest photo booth austin, stumptown williamsburg cornhole ethical hashtag readymade umami taiyaki drinking vinegar fixie.', 130, 100, 'a:4:{i:0;s:4:\"noir\";i:1;s:5:\"blanc\";i:2;s:11:\"bleu marine\";i:3;s:10:\"gris clair\";}', '2022-12-04 20:28:26', NULL, 1, 'a:0:{}'),
(4, 8, 1, 'Baskets usagés', 'Semiotics lyft freegan flexitarian viral tumblr succulents organic synth master cleanse glossier +1 twee 8-bit. Ugh raw denim twee microdosing scenester. Hella bruh adaptogen waistcoat taxidermy live-edge. Edison bulb schlitz subway tile 3 wolf moon.', 50, 15, 'a:4:{i:0;s:4:\"noir\";i:1;s:5:\"blanc\";i:2;s:11:\"bleu marine\";i:3;s:10:\"gris clair\";}', '2022-12-04 20:31:42', NULL, 0, 'a:0:{}'),
(5, 13, 5, 'Chaussettes de Noel', 'mash tun bittering hops alcohol ale brewing, cask priming amber shelf life. hop back bitter, hefe lauter tun racking, filter keg alpha acid. pitch balthazar wort chiller beer length hand pump heat exchanger caramel malt; wheat beer glass. oxidized noble hops terminal gravity original gravity oxidized. Aau dunkle krug, double bock/dopplebock imperial double bock/dopplebock hefe dry hopping noble hops cask conditioned ale beer original gravity pub. bright beer; brew cask conditioning filter keg lauter tun.', 130, 75, 'a:4:{i:0;s:4:\"noir\";i:1;s:5:\"blanc\";i:2;s:11:\"bleu marine\";i:3;s:10:\"gris clair\";}', '2022-12-04 20:33:39', NULL, 1, 'a:0:{}'),
(6, 13, 3, 'Chemises des années 80', 'Prosciutto biltong tenderloin shankle salami t-bone pig pork belly corned beef. Meatloaf pig boudin t-bone, bacon pastrami kevin filet mignon biltong shank turducken corned beef beef ribs prosciutto. Ribeye landjaeger shank beef sirloin bresaola fatback. Corned beef chuck tongue porchetta salami pork belly tail pig meatball.', 40, 30, 'a:4:{i:0;s:4:\"noir\";i:1;s:5:\"blanc\";i:2;s:11:\"bleu marine\";i:3;s:10:\"gris clair\";}', '2022-12-04 20:35:57', NULL, 1, 'a:0:{}');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`) VALUES
(5, 'yasminegherbibahia@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\", \"ROLE_SELLER\"]', '$2y$13$nXmNb/H1stm2vk4eTHecPOfZt.CMJq6kGlNeJYDso.h9H6FWf4xva', 'Yasmine', 'GHERBI BAHIA'),
(6, 'thomasleveille@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$JUCYKQVkebOmHdGdskUZgeA.JSZyNhl.v8ybjzn6voAy1c/73CBka', 'Thomas', 'Leveillé'),
(7, 'corentinesteve@gmail.com', '[]', '$2y$13$LCio2LGIWSuZC2vsjvuq.O30qCjKscuEvwm4.XcwjraY94bQ9bWRi', 'Corentin', 'Esteve'),
(8, 'lucastaranne@gmail.com', '[\"ROLE_SELLER\", \"ROLE_USER\"]', '$2y$13$LCio2LGIWSuZC2vsjvuq.O30qCjKscuEvwm4.XcwjraY94bQ9bWRi', 'Lucas', 'Taranne'),
(13, 'baptistecontini@gmail.com', '[\"ROLE_SELLER\"]', '$2y$13$LCio2LGIWSuZC2vsjvuq.O30qCjKscuEvwm4.XcwjraY94bQ9bWRi', 'Baptiste', 'CONTINI'),
(18, 'test@gmail.com', '[]', '$2y$13$HyEpL0wfj82grjGNpyPUhuGIthEsSvA8HrcTVh23GKQcefxAxqmzi', 'test', 'test');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article_user`
--
ALTER TABLE `article_user`
  ADD CONSTRAINT `FK_3DD151487294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3DD15148A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B77E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `FK_2890CCAA1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_2890CCAA4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD8DE820D98DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
