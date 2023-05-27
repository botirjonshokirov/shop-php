
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



--
-- Database: `grocery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` varchar(125) NOT NULL,
  `lastName` varchar(125) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `confirmCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `type`, `confirmCode`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '6464651', 'okay', 'f6fdffe48c908deb0f4c3bd36c032e72', 'admin', '789456'),
(2, 'Hiakosi', 'Castaneda', 'joana@gmail.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '21232f297a57a5a743894a0e4a801fc3', 'staff', '131527'),
(3, 'Jhenny', 'Lee', 'lee@gmail.com', '09207601999', 'longos', '69a9dc1da83c4c3e58a5ecb7c9de78fa', 'admin', '139474');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `uid`, `pid`, `quantity`) VALUES
(11, 2, 12, 0),
(12, 0, 46, 0),
(15, 43, 47, 0),
(19, 42, 54, 0),
(20, 42, 53, 0),
(21, 0, 47, 0),
(22, 0, 99, 0),
(23, 46, 81, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `oplace` text NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dstatus` varchar(10) NOT NULL DEFAULT 'no',
  `odate` date NOT NULL,
  `ddate` date NOT NULL,
  `delivery` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `pName` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `piece` int(11) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `pCode` varchar(20) NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `pName`, `price`, `piece`, `description`, `available`, `category`, `type`, `item`, `pCode`)
VALUES
(77, 'Product 1', 172, 8, 'Description for Product 1', 100, '', '', 'Bolttron', 'aa'),
(78, 'Product 2', 450, 6, 'Description for Product 2', 100, '', '', 'Sparklebot', 'bb'),
(79, 'Product 3', 350, 6, 'Description for Product 3', 100, '','', 'Bolttron', 'cc'),
(80, 'Product 4', 155, 5, 'Description for Product 4', 100, '','', 'Sparklebot', 'dd'),
(81, 'Product 5', 258, 2, 'Description for Product 5', 100, '','', 'Bolttron', 'ee'),
(82, 'Product 6', 110, 4, 'Description for Product 6', 100, '','', 'Sparklebot', 'ff'),
(83, 'Product 7', 185, 4, 'Description for Product 7', 100, '','', 'Bolttron',  'qq'),
(84, 'Product 8', 290, 24, 'Description for Product 8', 100, '','', 'Sparklebot', 'qwe'),
(85, 'Product 9', 300, 24, 'Description for Product 9', 100, '','', 'Bolttron', 'qwer'),
(86, 'Product 10', 160, 2, 'Description for Product 10', 100, '','', 'Sparklebot', 'qwrt'),
(87, 'Product 11', 160, 24, 'Description for Product 11', 100, '','', 'Bolttron', 'ryrty'),
(88, 'Product 12', 290, 5, 'Description for Product 12', 100, '','', 'Sparklebot', 'mnb'),
(90, 'Product 13', 238, 30, 'Description for Product 13', 100, '','', 'Bolttron', 'ads'),
(91, 'Product 14', 165, 4, 'Description for Product 14', 100, '','', 'Sparklebot',  'asdaa'),
(92, 'Product 15', 320, 5, 'Description for Product 15', 100, '','', 'Bolttron',  'adf'),
(93, 'Product 16', 100, 3, 'Description for Product 16', 100, '','', 'Sparklebot',  'gfhjgj'),
(94, 'Product 17', 180, 1, 'Description for Product 17', 100, '','', 'Bolttron',  'lkfjd'),
(95, 'Product 18', 190, 3, 'Description for Product 18', 100, '','', 'Sparklebot',  'lk'),
(96, 'Product 19', 100, 4, 'Description for Product 19', 100, '','', 'Bolttron', 'po'),
(97, 'Product 20', 110, 4, 'Description for Product 20', 100, '','', 'Sparklebot', 'n'),
(121, 'Product 21', 200, 8, 'Description for Product 21', 100, '', '', 'RoboRover', 'qwe'),
(122, 'Product 22', 150, 12, 'Description for Product 22', 100, '', '', 'ElectraTech', 'qwer'),
(123, 'Product 23', 180, 6, 'Description for Product 23', 100, '', '', 'AstroByte', 'qwrt'),
(124, 'Product 24', 250, 10, 'Description for Product 24', 100, '', '', 'DynaBot', 'ryrty'),
(125, 'Product 25', 300, 4, 'Description for Product 25', 100, '', '', 'Bolttron', 'mnb'),
(126, 'Product 26', 220, 24, 'Description for Product 26', 100, '', '', 'NexusPrime', 'ads'),
(127, 'Product 27', 320, 5, 'Description for Product 27', 100, '', 'other', 'Sparklebot', 'asdaa'),
(128, 'Product 28', 190, 3, 'Description for Product 28', 100, '', 'other', 'TurboX', 'adf'),
(129, 'Product 29', 110, 4, 'Description for Product 29', 100, '', '', 'RoboRover', 'gfhjgj'),
(130, 'Product 30', 160, 2, 'Description for Product 30', 100, '', '', 'ElectraTech', 'lkfjd'),
(131, 'Product 31', 180, 8, 'Description for Product 31', 100, '', '', 'AstroByte', 'lk'),
(132, 'Product 32', 250, 6, 'Description for Product 32', 100, '', '', 'DynaBot', 'n'),
(133, 'Product 33', 300, 4, 'Description for Product 33', 100, '', '', 'Bolttron', 'b'),
(134, 'Product 34', 220, 12, 'Description for Product 34', 100, '', '', 'NexusPrime', 'r'),
(135, 'Product 35', 320, 10, 'Description for Product 35', 100, '', '', 'Sparklebot', 'v'),
(136, 'Product 36', 190, 5, 'Description for Product 36', 100, '', 'other', 'TurboX', 'e'),
(137, 'Product 37', 110, 4, 'Description for Product 37', 100, '', '', 'RoboRover', 'a'),
(138, 'Product 38', 160, 24, 'Description for Product 38', 100, '', '', 'ElectraTech', 'nl'),
(139, 'Product 39', 200, 3, 'Description for Product 39', 100, '', '', 'AstroByte', 'ewr'),
(140, 'Product 40', 270, 48, 'Description for Product 40', 100, '', '', 'DynaBot', 'qwrt');




-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirmCode` varchar(10) NOT NULL,
  `activation` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `confirmCode`, `activation`) VALUES
(44, 'Jo', 'Castaneda', 'joanmcastaneda@gmail.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '69a9dc1da83c4c3e58a5ecb7c9de78fa', '0', 'yes'),
(45, 'KO', 'KOOOO', 'ko@w.com', '123', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '25d55ad283aa400af464c76d713c07ad', '289477', 'no'),
(46, 'Czyke', 'Correa', 'czyke@yahoo.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '7c09a95be9c2e9612c2bda758fc17e42', '0', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
