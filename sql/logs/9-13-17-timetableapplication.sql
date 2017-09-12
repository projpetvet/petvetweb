CREATE TABLE `time_table_appointments` (
  `id` int(11) NOT NULL,
  `time_table_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `time_table_appointments`
--
ALTER TABLE `time_table_appointments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `time_table_appointments`
--
ALTER TABLE `time_table_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;