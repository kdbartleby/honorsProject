-- MySQL dump 10.13  Distrib 5.5.50, for debian-linux-gnu (x86_64)

--
-- Host: 0.0.0.0    Database: project04_database
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table author
--

DROP TABLE IF EXISTS author;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE author (
  author_id int(11) NOT NULL AUTO_INCREMENT,
  first_name varchar(25) DEFAULT NULL,
  last_name varchar(25) DEFAULT NULL,
  PRIMARY KEY (author_id)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table author
--

LOCK TABLES author WRITE;
/*!40000 ALTER TABLE author DISABLE KEYS */;
INSERT INTO author VALUES (1,'Oliver','Sacks'),(5,'Claude M.','Steele'),(6,'Chinua','Achebe'),(7,'Jane','Austen'),(8,'Charles','Dickens'),(9,'Richard','Arum'),(10,'Joan','Casteel'),(11,'Patrick','Carey'),(12,'Erik','Larson'),(14,'Patrick','Pringle'),(15,'Lois','Lowry'),(16,'Mark','Twain'),(17,'Sandra','Cisneros'),(18,'Cormac','McCarthy'),(20,'Terry','Pratchett'),(21,'Ursula','Leguin'),(22,'Jonathan','Stroud'),(23,'Alfred','Lord Dunsany'),(24,'Andy','Weir'),(25,'Issac','Asimov'),(26,'Kage','Baker');
/*!40000 ALTER TABLE author ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table book
--

DROP TABLE IF EXISTS book;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE book (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(100) DEFAULT NULL,
  author_id int(11) DEFAULT NULL,
  genre_id int(11) DEFAULT NULL,
  description text,
  year_published varchar(6) DEFAULT NULL,
  origin_country varchar(50) DEFAULT NULL,
  cover varchar(32) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table book
--

LOCK TABLES book WRITE;
/*!40000 ALTER TABLE book DISABLE KEYS */;
INSERT INTO book VALUES (1,'An Anthropologist on Mars',1,6,'Sacks reports findings on several case studies, including a painter who lost the ability to see color, a surgeon, successful in spite of his Tourette\'s syndrome, and an autistic professor of animal science.','1995','United States',NULL),(2,'Whistling Vivaldi',5,6,'Steele looks at various stereotypes, their effects on individual performance and behavior, and suggests methods for change.','2010','United States',NULL),(3,'Emma',7,1,'Emma, a wealthy, intelligent, and somewhat self-centered young woman, against the advice of her friend Mr. Knightley, tries to foster an engagement between her friend Harriet Smith and Mr. Elton - it goes badly.','1815','Great Britain',NULL),(4,'Things Fall Apart',6,1,'Okonkwo, a proud, physically strong man, is one of the leaders of a village in present-day Nigeria. He, his three wives, and his children struggle with the traditional customs of the village, as well as with the start of British Colonialism in their area.','1958','Great Britain',NULL),(5,'A Tale of Two Cities',8,1,'Okonkwo, a proud, physically strong man, is one of the leaders of a village in present-day Nigeria. He, his three wives, and his children struggle with the traditional customs of the village, as well as with the start of British Colonialism in their area.','1859','Great Britain',NULL),(6,'The Sociology Project',9,8,'Arum and his fellow authors discuss various topics in sociology - social interaction, race, families, education, etc.','2013','United States',NULL),(7,'Oracle 12c: SQL',10,8,'Casteel takes the reader through SQL topics basic to advanced: queries, joins, creating and deleting tables, views, etc.','2016','United States',NULL),(8,'HTML and CSS 6th Edition',11,8,'Carey instructs the reader on topics in HTML and CSS','2012','United States',NULL),(9,'The Devil in the White City',12,4,'This non-fiction book tells the story of the 1893 World\'s Fair using a novelistic style; everyone is based on a person from real life.','2003','United States',NULL),(10,'Jolly Roger The Story of the Great Age of Piracy',14,4,'Pringle\'s account of the pirate era attempts to separate fact from fiction and chronicles the activities of the infamous men and women who sailed under the black flag.','1953','United States',NULL),(13,'Number the Stars',15,3,'Annemarie Johansen, a young girl living in Nazi-occupied Denmark, has to help her Jewish friend Ellen Rosen hide from the Nazis and escape to Sweden.','1989','United States',NULL),(14,'Personal Recollections of Joan of Arc',16,3,'This novel, presented as a translation of the notes of Joan of Arc\'s page, details the life of Joan of Arc.','1896','United States',NULL),(15,'The Road',18,5,'This novel tells of a father and son traveling across a post-apocalyptic landscape blasted by a cataclysm that destroyed most of civilization and life on earth.','2006','United States',NULL),(16,'The House on Mango Street',17,5,'Esperanza, a young Latina girl coming of age in downtown Chicago, must deal with racism, crime, and gender inequality.','1984','United States',NULL),(17,'Going Postal',20,2,'Moist von Lipwig, a notorious conman, escapes the death sentence by conscription into running the Ankh-Morpork post office. Among his concerns: a golem parole officer, mysterious banshee attacks, and pi = 3.','2004','United Kingdom',NULL),(18,'A Wizard of Earthsea',21,2,'Ged, a young man with a talent for mage craft, travels from his island home to study magic at the university, but while dueling with another student, he accidentally releases a terrible shadow creature.','1968','United States',NULL),(19,'The Amulet of Samarkand',22,2,'Bartimaeus, a djinni pressed into service by the twelve-year-old magician Nathaniel, takes every opportunity to creatively misinterpret his orders. Together, they must save the world, if they can stop bickering.','2003','United Kingdom',NULL),(20,'The Martian',24,7,'Mark Watney, a crew member of the first manned mission to Mars, is left behind by his crewmates when he\'s separated from them and believed dead. He must survive, alone, on the surface of Mars, until help arrives.','2011','United States',NULL),(21,'The Book of Wonder',23,2,'This collection of short stories contains such titles as \"The Distressing Story of Thangobrind the Jeweller, and the Doom that Befell Him\" and \"The Bride of the Man-Horse\". Dunsany\'s work had a great influence on Tolkien, Ursula LeGuin, and others.','1912','United Kingdom',NULL),(22,'I, Robot',25,7,'This collection of short stories focuses on robots becoming a part of society, the three laws that regulate their behavior, and what happens when the three laws don\'t work.','1950','United States',NULL),(23,'In the Garden of Iden',26,7,'A company called Dr. Zeus has invented immortality, so they invented time travel to test it. Mendoza, rescued as a small child from the dungeons of the Spanish Inquisition, is transformed into an immortal cyborg and is giving the task of conserving plants about to go extinct - but she falls in love with a human man along the way.','1997','United States',NULL);
/*!40000 ALTER TABLE book ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table genre
--

DROP TABLE IF EXISTS genre;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE genre (
  genre_id int(11) NOT NULL AUTO_INCREMENT,
  genre_name varchar(50) DEFAULT NULL,
  genre_description text,
  PRIMARY KEY (genre_id)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table genre
--

LOCK TABLES genre WRITE;
/*!40000 ALTER TABLE genre DISABLE KEYS */;
INSERT INTO genre VALUES (1,'Classic Literature','Works generally considered to have lasting merit; anything published over thirty years ago that still resonates in the current time and asks questions the current culture is still wrestlilng with'),(2,'Fantasy','Non-realistic fiction using magic or supernatural elements, often taking place in imaginary worldsand in either a medieval-like or modern setting'),(3,'Historical Fiction','Realistic work in a setting some time before the piece was written'),(4,'History','Factual work based on a certain person, event, or subject, backed by research in verifiable sources'),(5,'Modern Literature','Works published in the last twenty years that are widely considered exemplary and reflective of current societal concerns'),(6,'Psychology','Works about human behavior and the human mind and its functions'),(7,'Science Fiction','Fiction based on imagined future scientific or technological advances and major social or environmental changes, frequently portraying space or time travel and life on other planets'),(8,'Textbooks','Non-fiction works concerning a certain subject and intended for school instruction');
/*!40000 ALTER TABLE genre ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-31 16:36:32
