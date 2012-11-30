DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `youtube` text,
  `google` text,
  `adsense` text,
  `youtube2` text,
  `desc` text,
  `author` text,
  `keywords` text,
  `peuser` varchar(100) default NULL,
  `pepass` varchar(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `youtube`, `google`, `adsense`, `youtube2`, `desc`, `author`, `keywords`, `peuser`, `pepass`) VALUES
(1, '', NULL, NULL, NULL, 'Airbnb Clone', NULL, NULL, NULL, NULL);


DROP TABLE IF EXISTS `amnities`;
CREATE TABLE IF NOT EXISTS `amnities` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(111) NOT NULL,
  `description` varchar(333) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

INSERT INTO `amnities` (`id`, `name`, `description`) VALUES
(1, 'Smoking Allowed ', 'Smoking is allowed '),
(2, 'Pets Allowed ', 'Pets is allowed'),
(4, 'Cable TV ', 'Cable TV  is available'),
(6, 'Wireless Internet', 'A wireless router that guests can access 24/7.'),
(7, 'Air Conditioning', 'Air Conditioning is available'),
(8, 'Heating', 'Heating is available'),
(9, 'Elevator in Building ', 'Elevator is available in the building '),
(10, 'Handicap Accessible', 'The property is easily accessible.  Guests should communicate about individual needs.'),
(11, 'Pool', 'A private swimming pool'),
(12, 'Kitchen', 'Kitchen is available for guest use'),
(13, 'Parking Included', 'Parking Included'),
(14, 'Washer / Dryer', 'Washer / Dryer'),
(15, 'Doorman', 'Doorman'),
(16, 'Gym', 'Gym'),
(17, 'Hot Tub', 'Hot Tub'),
(18, 'Indoor Fireplace', 'Indoor Fireplace'),
(19, 'Buzzer/Wireless Intercom ', 'Buzzer/Wireless Intercom '),
(20, 'Breakfast', 'Breakfast is provided.'),
(21, 'Family/Kid Friendly', 'The property is suitable for hosting families with children.'),
(22, 'Suitable for Events', 'The property can accommodate a gathering of 25 or more attendees.');





DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('7513aadacc2258b7b87216906e356eb0', '0.0.0.0', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv', 1307957325, 'a:12:{s:10:"DX_user_id";s:2:"17";s:11:"DX_username";s:6:"magesh";s:10:"DX_role_id";s:1:"1";s:12:"DX_role_name";s:4:"User";s:18:"DX_parent_roles_id";a:0:{}s:20:"DX_parent_roles_name";a:0:{}s:13:"DX_permission";a:0:{}s:21:"DX_parent_permissions";a:0:{}s:12:"DX_logged_in";b:1;s:4:"user";s:2:"17";s:8:"username";s:6:"magesh";s:9:"logged_in";b:1;}'),
('d9fb989e2b792a7964d3caea86bcead0', '0.0.0.0', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv', 1307978034, 'a:12:{s:10:"DX_user_id";s:1:"1";s:11:"DX_username";s:5:"admin";s:10:"DX_role_id";s:1:"2";s:12:"DX_role_name";s:5:"Admin";s:18:"DX_parent_roles_id";a:0:{}s:20:"DX_parent_roles_name";a:0:{}s:13:"DX_permission";a:0:{}s:21:"DX_parent_permissions";a:0:{}s:12:"DX_logged_in";b:1;s:4:"user";s:1:"1";s:8:"username";s:5:"admin";s:9:"logged_in";b:1;}');


DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE IF NOT EXISTS `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `pincode` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `email_settings`;
CREATE TABLE IF NOT EXISTS `email_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(111) NOT NULL,
  `name` varchar(111) NOT NULL,
  `value` varchar(111) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;

INSERT INTO `email_settings` (`id`, `code`, `name`, `value`, `created`) VALUES
(1, 'MAILER_TYPE', 'Mailer Type', '1', 2011),
(2, 'SMTP_PORT', 'SMTP Port', '', 2011),
(3, 'SMTP_USER', 'SMTP Username', '', 2011),
(4, 'SMTP_PASS', 'SMTP Password', '', 2011),
(5, 'MAILER_MODE', 'Mailer Mode', 'html', 2011);


DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(64) CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `mail_subject` text CHARACTER SET utf8 NOT NULL,
  `email_body_text` text CHARACTER SET utf8 NOT NULL,
  `email_body_html` text CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63;

INSERT INTO `email_templates` (`id`, `type`, `title`, `mail_subject`, `email_body_text`, `email_body_html`) VALUES
(40, 'refferal_invite', 'Refferal Invitation', '{username} has invited you to {site_name}', 'Hi user,\r\n\r\n{username} wants you to save money with {site_name}\r\n\r\n{dynamic_content}\r\n\r\n{click_here}\r\n\r\n--\r\nThanks and Regards,\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi User,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{username} wants you to save money with {site_name}</p>\r\n<p>{dynamic_content}</p>\r\n<p>{click_here} To Started Now!</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(44, 'tc_book_to_admin', 'Admin notification for  Travel cretid booking', ' {traveler_name} sent the reservation request by using his Travel Cretids', 'Hello Admin,\r\n\r\n{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time} by using his Travel Credits.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nMarket Price : {market_price}\r\nPayed Amount : {payed_amount}\r\nTravel Credits : {travel_credits} \r\nHost Name : {host_name}\r\nHost Email Id : {host_email_id} \r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time} by using his Travel Credits.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Market Price : {market_price}</p>\r\n<p>Payed Amount : {payed_amount}</p>\r\n<p>Travel Credits : {travel_credits}</p>\r\n<p>Host Name : {host_name}</p>\r\n<p>Host Email Id : {host_email_id}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(45, 'tc_book_to_host', 'Host notification for  Travel cretid booking', ' {traveler_name} sent the reservation request by using his Travel Cretids', 'Hello {username},\r\n\r\n{traveler_name}sent the reservation request to book your {list_title} place on {book_date} at {book_time} by using his Travel Credits.\r\n\r\nWe will contact you with the appropriate payment.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nPrice : {market_price}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {username} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book your {list_title} place on {book_date} at {book_time} by using his Travel Credits.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Price : {market_price}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(46, 'admin_mass_email', 'Admin mass email', '{subject}', 'Hi User,\r\n\r\n{dynamic_content}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi User,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{dynamic_content}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(47, 'user_vouch', 'Vouch', 'Please vouch for {username}', 'Hello User,\r\n\r\n{username} is planning to start traveling like a human--its more affordable and fun than a hotel. Can you tell us why your friend is worth traveling with? Your recommendation will appear on your friends {site_name} profile and will help him/her be trusted by other travelers and hosts on the site.\r\n\r\nClick the below link to have a Recommendation for {username}\r\n{click_here}\r\n\r\nBy the way, will you be traveling soon? We have great people all over the world that you can stay with for less than the cost of a hotel. You can save $10 when you book using the coupon RECOMMENDATION on the payment screen.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi User,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{username} is planning to start traveling like a human--its more affordable and fun than a hotel. Can you tell us why your friend is worth traveling with? Your recommendation will appear on your friends {site_name} profile and will help him/her be trusted by other travelers and hosts on the site.</p>\r\n<p>{click_here} to have a Recommendation for {username}</p>\r\n<p>By the way, will you be traveling soon? We have great people all over the world that you can stay with for less than the cost of a hotel. You can save $10 when you book using the coupon RECOMMENDATION on the payment screen.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(48, 'host_reservation_notification', 'Reservation notification for host', 'The Reservation was requested by  {traveler_name}', 'Hello {username},\r\n\r\n{traveler_name} booked the {list_title} place on {book_date} at {book_time}.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nPrice : {market_price}\r\n\r\nPlease give the confirmation by clicking the below action.\r\n{action_url}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>Hi {username} ,</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name} booked the {list_title} place on {book_date} at {book_time}.</p>\r\n<br />\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Price : {market_price}</p>\r\n<br />\r\n<p>Please give the confirmation by clicking the below action.</p>\r\n<p>{action_url}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(49, 'traveller_reservation_notification', 'Reservation notification for  traveller', 'Your Reservation Request Is Succesfully Sent', 'Hello {traveler_name},\r\n\r\nYour reservation request is successfully sent to the appropriate host.\r\n\r\nPlease wait for his confirmation.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Your reservation request is successfully sent to the appropriate host.</p>\r\n<p>Please wait for his confirmation.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(50, 'admin_reservation_notification', 'Reservation notification for  administrator', '{traveler_name} sent the reservation request to {host_name}', 'Hello Admin,\r\n\r\n{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time}.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nMarket Price : {market_price}\r\nHost Name : {host_name}\r\nHost Email Id : {host_email_id} \r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time}.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Market Price : {market_price}</p>\r\n<p>Host Name : {host_name}</p>\r\n<p>Host Email Id : {host_email_id}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(51, 'traveler_reservation_granted', 'Traveler : After Reservation granted', 'Congrats! Your reservation request is granted', 'Hi {traveler_name},\r\n\r\nCongratulation, Your reservation request is granted by {host_name} for {list_name}.\r\n\r\nBelow we mentioned his contact details,\r\n\r\nFirst Name : {Fname}\r\nLast Name : {Lname}\r\nLive In : {livein}\r\nPhone No : {phnum}\r\n\r\nHost Message : {comment} \r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Congratulation, Your reservation request is granted by {host_name} for {list_name}.</p>\r\n<p>Below we mentioned his contact details,</p>\r\n<p>First Name : {Fname}</p>\r\n<p>Last Name : {Lname}</p>\r\n<p>Live In : {livein}</p>\r\n<p>Phone No : {phnum}</p>\r\n<p>Host Message : {comment}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(52, 'traveler_reservation_declined', 'Traveler : After reservation declined', 'Sorry! Your reservation request is denied', 'Hi {traveler_name},\r\n\r\nSorry, Your reservation request is dined by {host_name} for {list_title}.\r\n\r\nHost Message : {comment} \r\n\r\nSoon, We will contact you with the appropriate payment.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your reservation request is dined by {host_name} for {list_title}.</p>\r\n<p>Host Message : {comment}</p>\r\n<p>Soon, We will contact you with the appropriate payment.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(60, 'traveler_reservation_cancel', 'Traveler : After reservation canceled', '{host_name} canceled your reservation', 'Hi {traveler_name},\r\n\r\nSorry, Your confirmed reservation is dined by {host_name} for {list_title}.\r\n\r\nHost Message : {comment} \r\n\r\nSoon, We will contact you with the appropriate payment.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your confirmed reservation is dined by {host_name} for {list_title}.</p>\r\n<p>Host Message : {comment}</p>\r\n<p>Soon, We will contact you with the appropriate payment.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(53, 'traveler_reservation_expire', 'Traveler : Reservation Expire', 'Sorry! Your reservation request is expire', 'Hi {traveler_name},\r\n\r\nSorry, Your reservation request is expire by {host_name} for {list_title}.\r\n\r\nSoon, We will contact you with the appropriate payment.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your reservation request is expire by {host_name} for {list_title}.</p>\r\n<p>Soon, We will contact you with the appropriate payment.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(54, 'host_reservation_expire', 'Host : Reservation Expire', 'Reservation request expire for your host', 'Hi {host_name},\r\n\r\nReservation request expire for {list_title} that booked by {traveler_name}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Reservation request expire for {list_title} that booked by {traveler_name}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(55, 'admin_reservation_expire', 'Admin : Reservation Expire', 'Reservation request expired by  {host_name}', 'Hi Admin,\r\n\r\n{traveler_name} reservation request is expired by {host_name} for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}\r\n', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name} reservation request is expired by {host_name} for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(56, 'host_reservation_granted', 'Host : After Reservation Granted', 'You have accepted the {traveler_name} reservation request', 'Hi {host_name},\r\n\r\nYou have accepted the {traveler_name} reservation request for {list_title}.\r\n\r\nBelow we mentioned his contact details,\r\n\r\nFirst Name : {Fname}\r\nLast Name : {Lname}\r\nLive In : {livein}\r\nPhone No : {phnum}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have accepted the {traveler_name} reservation request for {list_title}.</p>\r\n<p>Below we mentioned his contact details,</p>\r\n<p>First Name : {Fname}</p>\r\n<p>Last Name : {Lname}</p>\r\n<p>Live In : {livein}</p>\r\n<p>Phone No : {phnum}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(57, 'admin_reservation_granted', 'Admin : After Reservation granted', '{host_name} accepted the {traveler_name} reservation request', 'Hi Admin,\r\n\r\n{host_name} accepted the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{host_name} accepted the {traveler_name} reservation request for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(58, 'host_reservation_declined', 'Host : After Reservation Declined', 'You have declined the {traveler_name} reservation request', 'Hi {host_name},\r\n\r\nYou have declined the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have declined the {traveler_name} reservation request} for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(59, 'admin_reservation_declined', 'Admin : After Reservation Declined', '{host_name} declined the {traveler_name} reservation request', 'Hi Admin,\r\n\r\n{host_name} declined the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{host_name} declined the {traveler_name} reservation request for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(61, 'admin_reservation_cancel', 'Admin : After reservation canceled', '{host_name} canceled the {traveler_name} confirmed reservation', 'Hi Admin,\r\n\r\n{host_name} canceled the {traveler_name} confirmed reservation for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{host_name} canceled the {traveler_name} confirmed reservation for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(62, 'host_reservation_cancel', 'Host : After reservation canceled', 'You have canceled the {traveler_name} confirmed reservation', 'Hi {host_name},\r\n\r\nYou have canceled the {traveler_name} confirmed reservation for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have canceled the {traveler_name} confirmed reservation for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>');



DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=28;

INSERT INTO `language` (`id`, `code`, `name`) VALUES
(2, 'bg', 'Bulgarian'),
(1, 'ar', 'Arabic'),
(3, 'zh-CN', 'Chinese(simplified)'),
(4, 'zh-TW', 'Chinese(traditional)'),
(5, 'hr', 'Croatian'),
(6, 'cs', 'Czech'),
(7, 'da', 'Danish'),
(8, 'nl', 'Dutch'),
(9, 'en', 'English'),
(10, 'fi', 'Finnish'),
(11, 'fr', 'French'),
(12, 'de', 'German'),
(13, 'el', 'Greek'),
(14, 'hi', 'Hindi'),
(15, 'it', 'Italian'),
(16, 'ja', 'Japanese'),
(17, 'ko', 'Korean'),
(18, 'no', 'Norwegian'),
(19, 'pl', 'Polish'),
(20, 'pt', 'Portuguese'),
(21, 'ro', 'Romanian'),
(22, 'ru', 'Russian'),
(23, 'es', 'Spanish'),
(24, 'sv', 'Swedish');


DROP TABLE IF EXISTS `language_core`;
CREATE TABLE IF NOT EXISTS `language_core` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

INSERT INTO `language_core` (`id`, `code`, `name`) VALUES
(1, 'en', 'English'),
(2, 'zh-CN', 'Chinese(simplified)'),
(3, 'zh-TW', 'Chinese(traditional)');


CREATE TABLE IF NOT EXISTS `list` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8,
  `exact` int(11) NOT NULL,
  `directions` text CHARACTER SET utf8,
  `lat` decimal(18,14) NOT NULL,
  `long` decimal(18,14) NOT NULL,
  `property_id` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `beds` int(11) NOT NULL,
  `bed_type` int(11) NOT NULL,
  `bathrooms` float NOT NULL,
  `amenities` varchar(111) NOT NULL,
  `title` text CHARACTER SET utf8,
  `desc` text CHARACTER SET utf8,
  `capacity` int(11) NOT NULL,
  `street_view` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `manual` text CHARACTER SET utf8 NOT NULL,
  `show_or_hide` varchar(10) NOT NULL DEFAULT 'active',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `page_viewed` bigint(20) NOT NULL,
  `review` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `list` (`id`, `user_id`, `address`, `exact`, `directions`, `lat`, `long`, `property_id`, `room_type`, `bedrooms`, `beds`, `bed_type`, `bathrooms`, `amenities`, `title`, `desc`, `capacity`, `street_view`, `price`, `currency`, `email`, `phone`, `manual`, `show_or_hide`, `status`, `page_viewed`, `review`) VALUES
(1, 1, 'Nauroji Nagar Marg, Safdarjung Enclave, New Delhi, Delhi, India', 0, '', 28.56542225683128, 77.19453682590333, 1, 'Private room', 4, 1, 0, 3.5, '1,13,17', 'Aradhna L Luxury B&B, New Delhi-Pine Room', 'Looking for a warm and friendly place to stay?\r\n\r\nWelcome to ‘On The House’, Bed and Breakfast, New Delhi.\r\n\r\nMore than just a place to sleep… a place to rest your soul !\r\n\r\nNo hotel, however grand, gives you the feel of home like On The House, Bed and Breakfast New Delhi does. Located in one of Delhi’s finest residential colonies, it has all the comforts of home with the conveniences of a hotel. From the privacy of an affluent residential area down to home-cooked food, everything at On The House, has a touch of home to it – offering elegant, inexpensive accommodation and warm hospitality with a quiet, relaxing and un-intruding atmosphere. On The House, has a unique style and combines contemporary design with the charm and intimacy of a private hotel, ideal for businessmen/women, professionals and tourists alike.\r\n\r\nThis bed & breakfast is absolutely safe with 24-hour security arrangements and reliable caretakers on the premises, making it a favorite, especially with single women travelers.\r\n\r\nMake yourself at home, savoring the elegantly appointed comfortable rooms decorated in individual color schemes with a touch of traditional artifacts giving each room a luxurious touch and its own identity. \r\n\r\nOn The House, Bed and Breakfast New Delhi has 3 well appointed Deluxe Bedrooms & 2 Superior Deluxe Bedrooms, clean, air-conditioned rooms, with attached private and exclusive bathrooms with western toilets, fully made up beds, safes for your valuables and mini fridges in the rooms. Luxurious Living & Dining Rooms provide an apartment living ambiance with a lovely terrace garden.\r\n\r\nThe Pine Room has vibrant shades of green and blue combine with classy wicker furniture and traditional Indian paintings to make this room very inviting. The park facing private balcony makes it a favorite with regular guests.\r\n\r\nOn The House, Bed and Breakfast is renowned for its spotless standards of cleanliness and warm, homely service. Keeping in mind the needs of the discerning traveler, the apartment has been tastefully furnished and decorated with a lot of thought given to every detail by the owner Ms. Aradhna Lanba.\r\n\r\nWe at On The House, Bed and Breakfast realize that staff plays an important role in the hospitality industry. They ensure that the guest can have all the comforts and conveniences they require. We have employed well-trained staff that is specially equipped to handle personalized services for you that fulfill all your needs as quickly as possible. Our commitment to you is for us to make your stay memorable. We wouldn''t want it any other way!\r\n\r\nWe provide complete housekeeping services. Whatever be your purpose - tourism, business, personal ... We offer a great ‘value for money’ experience. On The House, Bed and Breakfast has a touch of home to it. It has all the comforts of your home with the conveniences of a luxury hotel. The atmosphere at On The House, is warm, vibrant and friendly. It is located in a modern, park-facing building convenient for morning walks, jogging etc., in an exclusive, quiet and peaceful residential area of South Delhi. It is surrounded by trees and has greenery on all sides. We offer a well-stocked library of books, magazines and movies that the guests can use. For children and adults alike there are games. We have also taken care to stock for your convenience a number of items that you may have forgotten to bring along with you and need to use.\r\n\r\nIn short, On The House, is a ‘home away from home’ – the environment is relaxing, you can lounge around and have your meals in the warm, cheerful dining room or in the privacy of your bedroom.\r\n\r\nA labor of love, its owner Aradhna Lanba has created a comfortable, quiet and high-standard B&B. Guests are welcomed into an environment of subdued comfort and first-class service. Tastefully decorated guest rooms along with Living & Dining areas combine to make a memorable stay.\r\n\r\nLet us pamper you. Come stay with us!!\r\n', 1, 0, 63, 'USD', 'cogz1@cogzidel.com', '9952209611', '', 'hide', 1, 479, 0),
(2, 1, 'National Highway 67, Ooty, Tamil Nadu, India', 0, NULL, 11.41195420074064, 76.69552766137696, 1, 'Private room', 2, 0, 0, 0, '', ' Sepalika P It s top of a mountain near Lake', 'Cogzidel has now been a year since we started hosting on Airbnb_Clone, so I have edited this to be more precise anc clear based on feedback from guests. It''s a lot of information, but almost everything is answered and you should be able to make an informed decision about your stay.\r\nThanks for checking us out ! ', 1, 0, 40, 'USD', 'cog02@cozidel.com', '', '', 'active', 1, 513, 0),
(3, 1, '1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 0, '', 37.42136190000000, -122.08526370000000, 1, 'Private room', 1, 1, 0, 0, '', '500 Elizabeth St Melbourne VIC 3000 Australia', '500 Elizabeth St\r\nMelbourne VIC 3000\r\nAustralia', 1, 2, 100, 'USD', 'moses.jelsey@gmail.com', '9952209611', '', 'active', 1, 59, 0);


DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` bigint(20) unsigned NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL DEFAULT '0',
  `userby` int(11) NOT NULL,
  `userto` int(11) NOT NULL,
  `subject` varchar(70) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `created` varchar(30) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `is_starred` tinyint(4) NOT NULL,
  `message_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `message_type`;
CREATE TABLE IF NOT EXISTS `message_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;

INSERT INTO `message_type` (`id`, `name`, `url`) VALUES
(1, 'Reservation Request', 'trips/request'),
(2, 'Conversation', 'trips/conversation'),
(3, 'Message', 'trips/conversation'),
(4, 'Review Request', 'trips/review_by_host'),
(5, 'Review Request', 'trips/review_by_traveller');


DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(111) NOT NULL,
  `page_title` varchar(111) NOT NULL,
  `page_url` varchar(111) NOT NULL,
  `page_content` text NOT NULL,
  `created` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `payment_name` varchar(111) NOT NULL,
  `is_installed` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `pe_user` varchar(111) NOT NULL,
  `pe_password` varchar(111) NOT NULL,
  `pe_key` varchar(111) NOT NULL,
  `paypal_id` varchar(111) NOT NULL,
  `paypal_url` varchar(111) NOT NULL,
  `twoc_ventorid` varchar(50) NOT NULL,
  `twoc_security` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `payments` (`id`, `payment_name`, `is_installed`, `is_active`, `pe_user`, `pe_password`, `pe_key`, `paypal_id`, `paypal_url`, `twoc_ventorid`, `twoc_security`) VALUES
(2, 'Paypal', 0, 0, '', '', '', '', '', '', 'https://www.sandbox.paypal.com/cgi-bin/webscr');



DROP TABLE IF EXISTS `paymode`;
CREATE TABLE IF NOT EXISTS `paymode` (
  `id` tinyint(4) NOT NULL,
  `mod_name` varchar(111) NOT NULL,
  `is_premium` tinyint(4) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '0',
  `fixed_amount` float NOT NULL,
  `percentage_amount` float NOT NULL,
  `modified_date` varchar(111) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `paymode` (`id`, `mod_name`, `is_premium`, `is_fixed`, `fixed_amount`, `percentage_amount`, `modified_date`) VALUES
(1, 'Host Listing', 0, 0, 0, 0, ''),
(2, 'Guest Booking', 0, 0, 0, 0, ''),
(3, 'Host Accept The Reservation Request', 1, 0, 0, 10, '');


DROP TABLE IF EXISTS `payout_preferences`;
CREATE TABLE IF NOT EXISTS `payout_preferences` (
  `id` int(50) NOT NULL auto_increment,
  `country` varchar(20) NOT NULL,
  `payout_type` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `currency` varchar(15) NOT NULL,
  `default_email` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `paywhom`;
CREATE TABLE IF NOT EXISTS `paywhom` (
  `id` int(11) NOT NULL,
  `whom` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `paywhom` (`id`, `whom`) VALUES
(1, 0);


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `data` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL,
  `night` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `addguests` int(11) NOT NULL,
  `cleaning` int(11) NOT NULL,
  `security` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `price` (`id`, `night`, `week`, `month`, `addguests`, `cleaning`, `security`, `currency`) VALUES
(1, 63, 89, 370, 0, 0, 0, 'USD'),
(2, 40, 280, 1200, 35, 10, 60, 'USD'),
(3, 60, 420, 1800, 50, 25, 200, 'USD');


DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL,
  `Fname` varchar(255) DEFAULT NULL,
  `Lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `live` text,
  `work` text,
  `phnum` varchar(255) DEFAULT NULL,
  `describe` text,
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `profp`;
CREATE TABLE IF NOT EXISTS `profp` (
  `email` text NOT NULL,
  `src` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `recommends`;
CREATE TABLE IF NOT EXISTS `recommends` (
  `id` int(15) NOT NULL auto_increment,
  `user_id` int(15) NOT NULL,
  `friend_id` int(15) NOT NULL,
  `message` varchar(500) NOT NULL,
  `friend_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `list_id` int(111) NOT NULL,
  `userby` int(11) NOT NULL,
  `userto` int(111) NOT NULL,
  `checkin` varchar(50) NOT NULL,
  `checkout` varchar(50) NOT NULL,
  `no_quest` tinyint(4) NOT NULL,
  `price` float NOT NULL,
  `credit_type` tinyint(4) NOT NULL,
  `ref_amount` int(111) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `book_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `reservation_status`;
CREATE TABLE IF NOT EXISTS `reservation_status` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `reservation_status` (`id`, `name`) VALUES
(0, 'Payment Pending'),
(1, 'Pending'),
(2, 'Expired'),
(3, 'Accepted'),
(4, 'Declined'),
(5, 'Canceled by Host'),
(6, 'Canceled by Traveler'),
(7, 'Checkin'),
(8, 'Awaiting Host Review'),
(9, 'Awaiting Travel Review'),
(10, 'Completed');





DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `roles` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'User'),
(2, 0, 'Admin');


DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_type` char(1) CHARACTER SET utf8 NOT NULL,
  `value_type` char(1) CHARACTER SET utf8 NOT NULL,
  `int_value` int(12) DEFAULT NULL,
  `string_value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `text_value` text CHARACTER SET utf8,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `code`, `name`, `setting_type`, `value_type`, `int_value`, `string_value`, `text_value`, `created`) VALUES
(1, 'SITE_TITLE', 'Site Title', 'S', 'S', 0, 'Dropinn-v1.5', NULL, 1314431677),
(2, 'SITE_SLOGAN', 'Site Slogan', 'S', 'S', 0, 'Rent nightly from real people in 15,543 cities in 185 countries.', NULL, 2009),
(3, 'SITE_STATUS', 'Site status', 'S', 'I', 0, '', NULL, 2009),
(4, 'OFFLINE_MESSAGE', 'Offline Message', 'S', 'T', 0, '', 'Updation is going on...we will run this system very soon', 2009),
(5, 'SITE_ADMIN_MAIL', 'Site Admin Mail', 'S', 'S', NULL, 'rameshr@cogzidel.com', NULL, 1311680204),
(6, 'SITE_FB_API_ID', 'Site Facebook API ID', 'S', 'S', NULL, 'test', NULL, 1314431677),
(7, 'SITE_FB_API_SECRET', 'Site Facebook Secret Key', 'S', 'S', NULL, 'test', NULL, 1314431677),
(8, 'SITE_GMAP_API_KEY', 'Site Google Map Key', 'S', 'S', NULL, 'test', NULL, 1314431677),
(9, 'FRONTEND_LANGUAGE', 'Frontend Language', 'S', 'S', 1, 'en', 'en', 2009),
(10, 'SITE_LOGO', 'Site Logo', 'S', 'S', NULL, 'logo.png', NULL, 2011),
(11, 'META_KEYWORD', 'Meta Keyword', 'S', 'S', NULL, 'Dropinn', NULL, 2011),
(12, 'META_DESCRIPTION', 'Meta Description', 'S', 'S', NULL, 'Dropinn - Airbnb Clone', NULL, 2011),
(13, 'HOW_IT_WORKS', 'How It Works', 'S', 'S', 0, 'video.mp4', '', 2011),
(14, 'GOOGLE_ANALYTICS_CODE', 'Google Analytics Code', 'S', 'S', NULL, NULL, '', 2011),
(15, 'BACKEND_LANGUAGE', 'Backend Language', 'S', 'S', 1, 'en', 'en', 0);


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `ref_id` varchar(50) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `password` varchar(34) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255)  COLLATE utf8_bin DEFAULT NULL,
  `newpass` varchar(34) COLLATE utf8_bin DEFAULT NULL,
  `newpass_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `user_autologin`;
CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `user_profile` (`id`, `user_id`, `country`, `website`) VALUES
(1, 1, NULL, NULL),
(2, 4, NULL, NULL);


DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL auto_increment,
  `offers` varchar(5) NOT NULL,
  `news` varchar(5) NOT NULL,
  `upcoming_reservation` varchar(5) NOT NULL,
  `new_review` varchar(5) NOT NULL,
  `leave_review` varchar(5) NOT NULL,
  `standby` varchar(5) NOT NULL,
  `update_calendar` varchar(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_temp`;
CREATE TABLE IF NOT EXISTS `user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(34) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activation_key` varchar(50) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `settings_extra`;
CREATE TABLE IF NOT EXISTS `settings_extra` (
  `id` int(12) unsigned NOT NULL auto_increment,
  `code` varchar(100) character set utf8 NOT NULL,
  `name` varchar(255) character set utf8 NOT NULL,
  `setting_type` char(1) character set utf8 NOT NULL,
  `value_type` char(1) character set utf8 NOT NULL,
  `int_value` int(12) default NULL,
  `string_value` varchar(255) character set utf8 default NULL,
  `text_value` text character set utf8,
  `created` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;