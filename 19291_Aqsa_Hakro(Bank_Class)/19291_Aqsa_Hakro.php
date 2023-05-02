<?php
	class Bank{
		public $hostname 	= NULL;
		public $username 	= NULL;
		public $password 	= NULL;
		public $database 	= NULL;
		public $connection 	= NULL;
		public $query 		= NULL;
		public $result		= NULL;
		public $res_sel;


		public function __construct($hostname,$username, $password, $database){
			$this->hostname = $hostname;		
			$this->username = $username;		
			$this->password = $password;		
			$this->database = $database;


			mysqli_report(MYSQLI_REPORT_OFF);
			$this->connection = mysqli_connect($this->hostname, $this->username,$this->password, $this->database);

			if(mysqli_connect_errno()){
				echo "<p style='color:red'>Database Connection Problem <b>Errro No:</b> ".mysqli_connect_errno()." Errro Message: ".mysqli_connect_error()."</p>";
			}

		}

		public function user_information($name,$email,$number,$balance){

			$this->query = "INSERT INTO user_info(full_name,email,phone_number,bank_balance)
				VALUES('".$name."','".$email."','".$number."','".$balance."')";

		 	return $this->result = mysqli_query($this->connection,$this->query);

		}

		public function deposit($bank_account,$balance){

			$this->query = "UPDATE user_info
							SET bank_balance = bank_balance + $balance
							WHERE bank_account_no = $bank_account";

		 	return $this->result = mysqli_query($this->connection,$this->query);

		}

		public function withdraw($bank_account,$balance){

			$this->query = "UPDATE user_info
							SET bank_balance = bank_balance - $balance
							WHERE bank_account_no = $bank_account";

		 	return $this->result = mysqli_query($this->connection,$this->query);

		}

		public function show_user_account_information($bank_account){

			$this->query = "SELECT * FROM user_info
							WHERE bank_account_no = $bank_account";


			$this->res_sel = mysqli_query($this->connection,$this->query);
			 $result = $this->res_sel;

				if($result->num_rows > 0){
					while ($row = mysqli_fetch_assoc($result)) {
						?>
						<center style="padding-top: 20px;">
							<p><h2>USER INFORMATION</h2></p>
							<table border="2px" >
						<tr>
							<th>Full Name:</th>
							<th>Email:</th>
							<th>Phone Number:</th>
							<th>Bank Account Number:</th>
							<th>Bank Balance:</th>
						</tr>
						<tr>
							<td><?php echo $row['full_name']?></td>
							<td><?php echo $row['email']?></td>
							<td><?php echo $row['phone_number']?></td>
							<td><?php echo $row['bank_account_no']?></td>
							<td><?php echo $row['bank_balance']?></td>

						</tr>

						</table>

					</fieldset>
					
				</center>

						<?php
 
					}
				}
		}
	}

	$bank = new Bank("localhost","root","","bank_database");
	//$bank->user_information("saba","saba12@gmail.com","0330-1221156","5000");
	//$bank->user_information("Ahmed","ahmedali32@gmail.com","0330-0145678","129000");
	$bank->deposit("123006","2000");
	$bank->withdraw("123005","200");
	echo $bank->show_user_account_information("123006");
	// echo $bank->show_user_account_information("123005");




?>