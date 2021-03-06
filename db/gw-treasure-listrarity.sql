/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `listrarity` */

DROP TABLE IF EXISTS `listrarity`;

CREATE TABLE `listrarity` (
  `rareid` int(1) NOT NULL AUTO_INCREMENT,
  `rarity` varchar(6) DEFAULT NULL COMMENT 'white blue pruple gold green'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `listrarity` */

insert  into `listrarity`(`rarity`) values ('White'),('Blue'),('Purple'),('Gold'),('Green');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
