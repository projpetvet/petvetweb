CREATE TABLE `time_table` (
  `id` int(11) NOT NULL,
  `time_range` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_table`
--

INSERT INTO `time_table` (`id`, `time_range`) VALUES
(1, '9:00 am - 9:30 am'),
(2, '9:30 am - 10:00 am'),
(3, '10:00 am - 10:30 am'),
(4, '10:30 am - 11:00 am'),
(5, '11:00 am - 11:30 am'),
(6, '11:30 am - 12:00 pm'),
(7, '12:00 pm - 12:30 pm'),
(8, '12:30 pm - 1:00 pm'),
(9, '1:00 pm - 1:30 pm'),
(10, '1:30 pm - 2:00 pm'),
(11, '2:00 pm - 2:30 pm'),
(12, '2:30 pm - 3:00 pm'),
(13, '3:00 pm - 3:30 pm'),
(14, '3:30 pm - 4:00 pm'),
(15, '4:00 pm - 4:30 pm'),
(16, '4:30 pm - 5:00 pm'),
(17, '5:00 pm - 5:30 pm'),
(18, '5:30 pm - 6:00 pm'),
(19, '6:00 pm - 6:30 pm'),
(20, '6:30 pm - 7:00 pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `time_table`
--
ALTER TABLE `time_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `time_table`
--
ALTER TABLE `time_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;