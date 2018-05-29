<?php
/**
 * FP Platform
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    FPPlatform
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class EmailTemplateData {

	public $table = 'email_templates';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2009-02-20 10:24:49',
			'modified' => '2013-11-19 14:21:27',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Forgot Password',
			'description' => 'we will send this mail, when user submit the forgot password form.',
			'subject' => 'Forgot password',
			'email_text_content' => 'Hi ##USERNAME##,

A password reset request has been made for your user account at ##SITE_NAME##.

If you made this request, please click on the following link:

##RESET_URL##

If you did not request this action and feel this is an error, please contact us.

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

	<table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A password reset request has been made for your user account at ##SITE_NAME##.  If you made this request, please click on the following link:  ##RESET_URL##  

</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL## 

</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME,RESET_URL,SITE_NAME,SITE_LINK'
		),
		array(
			'id' => '2',
			'created' => '2009-02-20 10:15:57',
			'modified' => '2013-11-19 14:21:49',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Activation Request',
			'description' => 'we will send this mail, when user registering an account he/she will get an activation request.',
			'subject' => 'Please activate your ##SITE_NAME## account',
			'email_text_content' => 'Hi ##USERNAME##,

Your account has been created. 

Please visit the following URL to activate your account.

##ACTIVATION_URL##

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been created.</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please visit the following URL to activate your account.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##ACTIVATION_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,ACTIVATION_URL,SITE_LINK'
		),
		array(
			'id' => '3',
			'created' => '2009-02-20 10:15:19',
			'modified' => '2013-11-19 14:22:11',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'New User Join',
			'description' => 'we will send this mail to admin, when a new user registered in the site. For this you have to enable \"admin mail after register\" in the settings page.',
			'subject' => '[##SITE_NAME##] New user joined',
			'email_text_content' => 'Hi, 

A new user named \"##USERNAME##\" has joined in ##SITE_NAME##.

Username: ##USERNAME##

E-mail: ##USEREMAIL##

Sign up IP: ##SIGNUPIP##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A new user named \"##USERNAME##\" has joined in ##SITE_NAME##.</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Username: ##USERNAME##</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Email: ##USEREMAIL##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Signup IP: ##SIGNUPIP##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,SITE_LINK'
		),
		array(
			'id' => '4',
			'created' => '2009-03-02 00:00:00',
			'modified' => '2013-11-19 14:22:37',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin User Add',
			'description' => 'we will send this mail to user, when a admin add a new user.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Hi ##USERNAME##,

##SITE_NAME## team added you as a user in ##SITE_NAME##.

Your account details,

##LOGINLABEL##: ##USEDTOLOGIN##

Password: ##PASSWORD##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team added you as a user in ##SITE_NAME##.

</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account details.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Please ##LOGINLABEL##:##USEDTOLOGIN##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Password:##PASSWORD##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,PASSWORD, LOGINLABEL, USEDTOLOGIN, SITE_URL'
		),
		array(
			'id' => '5',
			'created' => '2009-05-22 16:51:14',
			'modified' => '2013-11-14 09:00:39',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Welcome Email',
			'description' => 'we will send this mail, when user register in this site and get activate.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Hi ##USERNAME##,

We wish to say a quick hello and thanks for registering at ##SITE_NAME##.

If you did not request this account and feel this is an error, please

contact us at ##CONTACT_MAIL##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">We wish to say a quick hello and thanks for registering at ##SITE_NAME##.</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this account and feel this is an error, please

contact us at ##CONTACT_MAIL##.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, USERNAME, SUPPORT_EMAIL, SITE_URL'
		),
		array(
			'id' => '7',
			'created' => '2009-05-22 16:45:38',
			'modified' => '2013-11-19 14:23:29',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin User Active',
			'description' => 'We will send this mail to user, when user active   

by administator.',
			'subject' => 'Your ##SITE_NAME## account has been activated',
			'email_text_content' => 'Hi ##USERNAME##,

Your account has been activated.

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been activated.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,SITE_LINK'
		),
		array(
			'id' => '8',
			'created' => '2009-05-22 16:48:38',
			'modified' => '2013-11-19 14:23:46',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin User Deactivate',
			'description' => 'We will send this mail to user, when user deactive by administator.',
			'subject' => 'Your ##SITE_NAME## account has been deactivated',
			'email_text_content' => 'Hi ##USERNAME##,

Your ##SITE_NAME## account has been deactivated.

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been deactivated.</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,SITE_LINK'
		),
		array(
			'id' => '23',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:43:13',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Notification For Inactive Users',
			'description' => 'External alert mail sent to users who are inactive for the days set in the admin side user settings.',
			'subject' => '##SITE_NAME##: Important account notice',
			'email_text_content' => 'Hi ##USERNAME##,

You are receiving this email because you have ##JOB_ALT_NAME_PLURAL## listed on ##SITE_NAME## and we noticed that you did not visit your account lately.

To keep your ##JOB_ALT_NAME_PLURAL## listed on ##SITE_NAME##, please click here

##SITE_URL##users/login. 

This is made to insure that buyers will not order services from inactive sellers.

-- 

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You are receiving this email because you have ##JOB_ALT_NAME_PLURAL## listed on ##SITE_NAME## and we noticed that you did not visit your account lately.

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

To keep your ##JOB_ALT_NAME_PLURAL## listed on ##SITE_NAME##, please click here

##SITE_URL##users/login. </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">This is made to insure that buyers will not order services from inactive sellers.</p></td>

                </tr>           

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, SITE_NAME, SITE_URL, JOB_ALT_NAME_PLURAL'
		),
		array(
			'id' => '24',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:44:36',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Order Alert Mail',
			'description' => 'This is an external alert mail sent to the user when they receive any message into their internal messages related to orders.',
			'subject' => '##SITE_NAME##: ##TO_USER## - ##SUBJECT##',
			'email_text_content' => 'Hi ##TO_USER##, 

##MESSAGE##

To view the full message and attachments (if any) click on the following link:

 ##VIEW_LINK## 

This is an automatically generated message by ##SITE_NAME##

Replies are not monitored or answered.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##TO_USER##, </p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##MESSAGE##

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

To view the full message and attachments (if any) click on the following link: </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##VIEW_LINK## </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">This is an automatically generated message by ##SITE_NAME## Replies are not monitored or answered.

</p></td>

                </tr>               

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'TO_USER,SITE_NAME,FROM_USER,SUBJECT,MESSAGE,VIEW_LINK,SITE_URL,REFER_LINK'
		),
		array(
			'id' => '9',
			'created' => '2009-05-22 16:50:25',
			'modified' => '2013-11-19 14:24:08',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin User Delete',
			'description' => 'We will send this mail to user, when user delete by administrator.',
			'subject' => 'Your ##SITE_NAME## account has been removed',
			'email_text_content' => 'Hi ##USERNAME##,

Your ##SITE_NAME## account has been removed.

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your ##SITE_NAME## account has been removed.</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'SITE_NAME,USERNAME,SITE_LINK'
		),
		array(
			'id' => '10',
			'created' => '2009-07-07 15:47:09',
			'modified' => '2013-11-19 14:24:27',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin Change Password',
			'description' => 'we will send this mail to user, when admin change user\'s password.',
			'subject' => 'Password changed',
			'email_text_content' => 'Hi ##USERNAME##,

Admin reset your password for your  ##SITE_NAME## account.

Your new password: ##PASSWORD##

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Admin reset your password for your  ##SITE_NAME## account.</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your new password: ##PASSWORD##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>

',
			'email_variables' => 'SITE_NAME,PASSWORD,USERNAME,SITE_LINK'
		),
		array(
			'id' => '11',
			'created' => '2009-10-14 18:31:14',
			'modified' => '2013-11-19 14:24:50',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Contact Us',
			'description' => 'We will send this mail to admin, when user submit any contact form.',
			'subject' => '[##SITE_NAME##] ##SUBJECT##',
			'email_text_content' => '##MESSAGE##

-- 

----------------------------------------------------

Telephone    : ##TELEPHONE##

IP           : ##IP##, ##SITE_ADDR##

Whois        : http://whois.sc/##IP##

URL          : ##FROM_URL##

----------------------------------------------------',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##MESSAGE##</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Telephone    : ##TELEPHONE##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">IP           : ##IP##, ##SITE_ADDR##</p></td>

                </tr><tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Whois        : http://whois.sc/##IP##</p></td>

                </tr><tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL          : ##FROM_URL##</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'FROM_URL, IP, TELEPHONE, MESSAGE, SITE_NAME, SUBJECT, FROM_EMAIL, LAST_NAME, FIRST_NAME'
		),
		array(
			'id' => '12',
			'created' => '2009-10-14 19:20:59',
			'modified' => '2013-11-19 14:25:17',
			'from' => '##CONTACT_FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Contact Us Auto Reply',
			'description' => 'we will send this mail ti user, when user submit the contact us form.',
			'subject' => '[##SITE_NAME##] RE: ##SUBJECT##',
			'email_text_content' => 'Hi ##FIRST_NAME####LAST_NAME##,

   Thanks for contacting us. We\'ll get back to you shortly.

   Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##

------ On ##POST_DATE## you wrote from ##IP## -----

##MESSAGE##

Thanks,

##SITE_NAME##

##SITE_URL##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Thanks for contacting us. We\'ll get back to you shortly.</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##

</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

',
			'email_variables' => 'MESSAGE, POST_DATE, SITE_NAME, CONTACT_URL, FIRST_NAME, LAST_NAME, SUBJECT, SITE_URL'
		),
		array(
			'id' => '13',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:32:18',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'New order notification',
			'description' => 'When new order was made, an internal message will be sent to the owner of the job notifiying an new order.',
			'subject' => 'You have new order',
			'email_text_content' => 'Dear ##USERNAME##

You have a new order from ##BUYER_USERNAME##.

The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Please click the following link to accept the order

##ACCEPT_URL##

Please click the following link to reject the order

##REJECT_URL##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">You have a new order from ##BUYER_USERNAME##.

The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to accept the order

##ACCEPT_URL##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Please click the following link to reject the order

##REJECT_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME,BUYER_USERNAME,JOB_NAME,ACCEPT_URL,REJECT_URL, JOB_ALT_NAME'
		),
		array(
			'id' => '14',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:34:18',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Accepted order notification',
			'description' => 'Internal message will be sent to the buyer, when the ordered job was accepted by the seller.',
			'subject' => 'Your order has been accepted',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been accepted. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

##SELLER_CONTACT##

You need to give this below verification code to the seller once your order has been succesfully done. 

##VERIFICATION_CODE##

##PRINT##

Print option will be available for the above code in Shopping -> Track order page.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your order has been accepted. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##SELLER_CONTACT##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> You need to give this below verification code to the seller once your order has been succesfully done. ##VERIFICATION_CODE##</p></td>

                </tr>

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##PRINT##</p></td>

                </tr>

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Print option will be available for the above code in Shopping -> Track order page.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME, JOB_ALT_NAME'
		),
		array(
			'id' => '15',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:35:29',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Rejected order notification',
			'description' => 'Internal message will be sent to the buyer, when the ordered job was rejected by the seller.',
			'subject' => 'Your order has been rejected',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been rejected. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your order has been rejected. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME, JOB_ALT_NAME'
		),
		array(
			'id' => '16',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:36:24',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Cancelled order notification',
			'description' => 'Internal message will be sent to the seller, when the ordered job was cancelled by the buyer.',
			'subject' => 'Your order has been cancelled',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been cancelled. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your order has been cancelled. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME, JOB_ALT_NAME'
		),
		array(
			'id' => '18',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:37:50',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Buyer review notification',
			'description' => 'Internal message will be sent to the buyer, when the ordered job was completed by the seller and waiting for the buyer to make the review.',
			'subject' => 'Your order has been completed',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been completed and waiting for your review and completion of work.

Please click the following link to review the order

##REVIEW_URL##

The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##

Note:  You have to review this order within ##AUTO_REVIEW_DAY## days otherwise the order will be auto reviewed by admin and will get close.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your order has been completed and waiting for your review and completion of work.</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Please click the following link to review the order

##REVIEW_URL##</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Note:  You have to review this order within ##AUTO_REVIEW_DAY## days otherwise the order will be auto reviewed by admin and will get close.</p></td>

                </tr>               

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME,REVIEW_URL, JOB_ALT_NAME'
		),
		array(
			'id' => '20',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:38:55',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Completed order notification',
			'description' => 'Internal message will be sent to the seller, when the buyer makes the review and the order gets completed after that process.',
			'subject' => 'Your order has been verified',
			'email_text_content' => 'Dear ##USERNAME##, 

##BUYER_USERNAME## has verified your work completion on order ###ORDERNO##, of ##JOB_NAME##.

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##BUYER_USERNAME## has verified your work completion on order ###ORDERNO##, of ##JOB_NAME##.</p></td>

                </tr>              

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, ORDERNO, BUYER_USERNAME,JOB_NAME'
		),
		array(
			'id' => '21',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:40:06',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Auto expired notification',
			'description' => 'Internal message will be sent to the buyer and seller mentioning the order was expired, when the ordered job was not accepted by the seller within the autoexpire limit.',
			'subject' => 'Your order has been expired',
			'email_text_content' => 'Dear ##USERNAME##, 

##JOB_ALT_NAME## ##JOB_NAME## has been expired.

The order ###ORDERNO## was not accepted within ##EXPIRE_DATE##.

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ##JOB_NAME## has been expired.

The order ###ORDERNO## was not accepted within ##EXPIRE_DATE##.</p></td>

                </tr>            

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME, ORDERNO, EXPIRE_DATE, JOB_ALT_NAME'
		),
		array(
			'id' => '22',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:41:36',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Alert Mail',
			'description' => 'This is an external alert mail sent to the users when they receive any message into their internal messages related to contacting users.',
			'subject' => '##SITE_NAME##: You have a new message from ##FROM_USER##',
			'email_text_content' => 'Hi ##TO_USER##,

A new message from ##FROM_USER## is waiting for you in your inbox. 

To reply to this message click here: ##REPLY_LINK## 

To view the full message and attachments (if any) click on the following link:

 ##VIEW_LINK##

This is an automatically generated message by ##SITE_NAME## Replies are not monitored or answered.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##TO_USER##,</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

A new message from ##FROM_USER## is waiting for you in your inbox. 

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

To reply to this message click here: ##REPLY_LINK## </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the full message and attachments (if any) click on the following link:

 ##VIEW_LINK##</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">This is an automatically generated message by ##SITE_NAME## Replies are not monitored or answered.

</p></td>

                </tr>               

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,FROM_USER, TO_USER, SUBJECT,MESSAGE,REPLY_LINK,VIEW_LINK,SITE_URL'
		),
		array(
			'id' => '25',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:45:58',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Invite New User',
			'description' => 'This external mail will be sent, when users sends an invitation to other users.',
			'subject' => '##USERNAME## would like to add you as a contact at ##SITE_NAME##',
			'email_text_content' => 'Hi, 

##USERNAME##, requested you to join his/her ##SITE_NAME## network.

I have joined the ##SITE_NAME## network. I wish to invite you to ##SITE_NAME## as well.

Click below to register in the site

##REFER_LINK##

Join fast!

##USERNAME##

-- 

Thanks, 

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi, </p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##USERNAME##, requested you to join his/her ##SITE_NAME## network.

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

I have joined the ##SITE_NAME## network. I wish to invite you to ##SITE_NAME## as well. </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Click below to register in the site

##REFER_LINK##</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Join fast!

##USERNAME##

</p></td>

                </tr>               

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_LINK, SITE_NAME, USERNAME, REFER_LINK'
		),
		array(
			'id' => '26',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:47:21',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'In Progress Overtime',
			'description' => 'Internal message sent when order is in-progress and exceeds its published duration by number of days set in admin and thereby autochanges the status from \'inprogress\' to \'inprogress overtime\'.',
			'subject' => 'Your order has exceed the published duration',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has exceed the published duration. The ##JOB_ALT_NAME##, ordered is: ##JOB_NAME##.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order has exceed the published duration. The ##JOB_ALT_NAME##, ordered is: ##JOB_NAME##.

</p></td>

                </tr>             

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_NAME,JOB_ALT_NAME'
		),
		array(
			'id' => '27',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:52:49',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'New order buyer notification',
			'description' => 'Internal mail sent to the buyer when he makes a new order.',
			'subject' => 'Your order was sent to the seller',
			'email_text_content' => '##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##

Dear ##USERNAME##,

Your order has been sent to the seller and is now waiting for their approval. We will notify you when that happens. Please keep this mail until your order is complete.

The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

----------------------------------

Information about your order

----------------------------------

Order ###ORDER_NO##

##JOB_FULL_NAME##

Description:

##JOB_DESCRIPTION##

Expected completion days:

##JOB_ORDER_COMPLETION_DATE##

Seller:

##SELLER_NAME## (##SELLER_RATING##) ##SELLER_CONTACT_LINK##

----------------------------------

What to do if the seller is not responding?

----------------------------------

If you feel that the seller is taking too long to respond, you can ##CANCEL_URL## and get your funds back to your Account. We recommend allowing sellers at least ##JOB_AUTO_EXPIRE_DATE## hours to respond.

----------------------------------

What if the seller rejects my order?

----------------------------------

Sellers may sometimes choose to give up on an order. This may be due to their inability to perform their work based on the information you provided or they are simply too busy. 

If a seller rejects your order, your funds are returned to your ##SITE_NAME## account.

----------------------------------

##SITE_NAME## Customer Service

----------------------------------

The ##SITE_NAME## Customer service are here to help you. If you need any assistance with an order, Please contact us here: ##CONTACT_LINK##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order has been sent to the seller and is now waiting for their approval. We will notify you when that happens. Please keep this mail until your order is complete.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Information about your order

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Order ###ORDER_NO##

##JOB_FULL_NAME##

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Description:

##JOB_DESCRIPTION##

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Expected completion days:

##JOB_ORDER_COMPLETION_DATE##

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Seller:

##SELLER_NAME## (##SELLER_RATING##) ##SELLER_CONTACT_LINK##

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">What to do if the seller is not responding?

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you feel that the seller is taking too long to respond, you can ##CANCEL_URL## and get your funds back to your Account. We recommend allowing sellers at least ##JOB_AUTO_EXPIRE_DATE## hours to respond.

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">What if the seller rejects my order?

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Sellers may sometimes choose to give up on an order. This may be due to their inability to perform their work based on the information you provided or they are simply too busy. 

If a seller rejects your order, your funds are returned to your ##SITE_NAME## account.

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## Customer Service

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The ##SITE_NAME## Customer service are here to help you. If you need any assistance with an order, Please contact us here: ##CONTACT_LINK##

</p></td>

                </tr>           

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SELLER_NAME, USERNAME, JOB_ALT_NAME, JOB_FULL_NAME, JOB_DESCRIPTION, JOB_ORDER_COMPLETION_DATE

SELLER_RATING, SELLER_CONTACT_LINK, REJECT_URL, BALANCE_LINK, JOB_AUTO_EXPIRE_DATE, CONTACT_LINK'
		),
		array(
			'id' => '28',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:54:47',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'New order buyer Mail',
			'description' => 'External mail to the buyer when he makes an new order.',
			'subject' => 'Your order has been placed',
			'email_text_content' => 'Dear ##USERNAME##

your order has been sent to the seller and is now waiting for their approval.

You will be notified once that happens.

This is an automatically generated message by ##SITE_NAME##

Replies are not monitored or answered.

Thanks

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

your order has been sent to the seller and is now waiting for their approval.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> You will be notified once that happens.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">This is an automatically generated message by ##SITE_NAME##

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Replies are not monitored or answered.

</p></td>

                </tr>  

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, SITE_NAME, SITE_URL'
		),
		array(
			'id' => '30',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:56:09',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Accept order seller notification',
			'description' => 'Internal message sent back to seller after the order has been accepted.

',
			'subject' => 'You have accepted the order',
			'email_text_content' => 'Dear ##USERNAME##,

You have accepted the order.

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

##BUYER_CONTACT##

Be sure you get verification code from buyer once you completed your job.

Verification code is need to confirm that you have succefully completed the job.

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You have accepted the order.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##BUYER_CONTACT##

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Be sure you get verification code from buyer once you completed your job.

Verification code is need to confirm that you have succefully completed the job.

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '31',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:57:06',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Rejected order seller notification',
			'description' => 'Internal message sent back to seller after the order has been rejected.

',
			'subject' => 'You have rejected the order',
			'email_text_content' => 'Dear ##USERNAME##,

You have rejected the order:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You have rejected the order:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '32',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:58:15',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Cancelled order buyer notification',
			'description' => 'Internal message sent back to buyer after the order has been canceled.',
			'subject' => 'You have cancelled the order',
			'email_text_content' => 'Dear ##USERNAME##,

You have cancelled the order:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You have cancelled the order:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '33',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:59:36',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Buyer review seller notification',
			'description' => 'Internal message sent back to seller after the order has been completed and delivered.',
			'subject' => 'You have delivered your work',
			'email_text_content' => 'Dear ##USERNAME##,

You have delivered the order  and is now waiting for the buyer review.

You will be notified once that happens.

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You have delivered the order  and is now waiting for the buyer review.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> You will be notified once that happens.</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##JOB_ALT_NAME## ordered is: ##JOB_NAME##.Order#: ##ORDERNO##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '34',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 15:00:39',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Completed order buyer notification',
			'description' => 'Internal message sent back to buyer after the order has been reviewed and completed.',
			'subject' => 'Your order has completed.',
			'email_text_content' => 'Dear ##USERNAME##,

Thanks for your review.

The order has been completed.

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Thanks for your review.

The order has been completed.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '35',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 15:01:38',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Cleared amount notification',
			'description' => 'Internal message sent to the seller when the amount for the order has been cleared.',
			'subject' => 'Your amount has been cleared',
			'email_text_content' => 'Dear ##USERNAME##,

Your amount for the order has been cleared for withdrawal.

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your amount for the order has been cleared for withdrawal.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '36',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 15:02:30',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin rejected order notification',
			'description' => 'Internal message sent when order has rejected by admin. This happens when an job has been suspend by administrator',
			'subject' => 'Your order has been cancelled by Administrator',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been cancelled by administrator:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order has been cancelled by administrator:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '37',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:00:18',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Admin rejected order seller notification',
			'description' => 'Internal message sent back to the seller when order has been cancelled by administrator. This happen when administrator suspends the sellers job.',
			'subject' => 'Your order has been cancelled by Administrator',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been cancelled by administrator:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order has been cancelled by administrator:

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '38',
			'created' => '2010-12-04 10:14:29',
			'modified' => '2013-11-20 05:01:14',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Requested Job Notification',
			'description' => 'we will send this mail, when the job related for the user request',
			'subject' => '##JOB_ALTERNATIVE_NAME## posted for your ##REQUEST_ALTERNATIVE_NAME##',
			'email_text_content' => 'Hi ##USERNAME##,

A job related to your ##REQUEST_ALTERNATIVE_NAME## ##REQUEST_URL## has been posted in ##SITE_NAME##.

Please visit the following URL to view the ##JOB_ALTERNATIVE_NAME## ##JOB_URL##

Thanks,

##SITE_NAME##

##SITE_LINK##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Hi ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

A job related to your ##REQUEST_ALTERNATIVE_NAME## ##REQUEST_URL## has been posted in ##SITE_NAME##.

Please visit the following URL to view the ##JOB_ALTERNATIVE_NAME## ##JOB_URL##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME, JOB_URL, SITE_LINK,REQUEST_ALTERNATIVE_NAME , REQUEST_URL, JOB_ALTERNATIVE_NAME'
		),
		array(
			'id' => '39',
			'created' => '2010-06-07 13:53:59',
			'modified' => '2013-11-20 05:04:46',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Auto review notification',
			'description' => 'Internal message will be sent to the buyer, when the ordered job was auto reviewed by admin.',
			'subject' => 'Notification For ##JOB_ALT_NAME## has been auto reviewed by admin.',
			'email_text_content' => 'Dear ##USERNAME##,

This is to inform you that you have not reviewed ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO## within the mention time duration. So the ##JOB_ALT_NAME## has been auto reviewed by admin.

The order has been completed.

To view the ##JOB_ALT_NAME## status click on the following link: 

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

This is to inform you that you have not reviewed ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO## within the mention time duration. So the ##JOB_ALT_NAME## has been auto reviewed by admin.

The order has been completed.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  To view the ##JOB_ALT_NAME## status click on the following link: 

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, JOB_NAME, ORDERNO'
		),
		array(
			'id' => '40',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:06:18',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Redeliver notification mail',
			'description' => 'Internal message sent back for redeliver request mail.',
			'subject' => '##OTHER_USER## has requested for redeliver of your work',
			'email_text_content' => 'Dear ##USERNAME##,

##OTHER_USER## has sent the following message and requested to redeliver the ##JOB_ALT_NAME##.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## has sent the following message and requested to redeliver the ##JOB_ALT_NAME##.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##JOB_ALT_NAME## ordered is: ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Order#: ##ORDERNO##

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '41',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:07:17',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Redeliver cancel notification',
			'description' => 'Internal message sent back to seller after buyer sent the order deliver request.',
			'subject' => '##OTHER_USER## has cancelled the redeliver request',
			'email_text_content' => 'Dear ##USERNAME##,

The redeliver request made before has been cancelled by the buyer.

So, you dont need to redeliver the work.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

The redeliver request made before has been cancelled by the buyer.So, you dont need to redeliver the work.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>   

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '42',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:08:17',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Mutual Cancel Request Notification',
			'description' => 'Notification mail for mutual cancel',
			'subject' => '##OTHER_USER## has requested to cancel the order',
			'email_text_content' => 'Dear ##USERNAME##,

##OTHER_USER## has sent the following message and requested to cancel the order.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## has sent the following message and requested to cancel the order.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '43',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:09:58',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Mutual Cancelled order notification',
			'description' => 'Order has been mutually cancelled.',
			'subject' => 'Your order has been mutually cancelled',
			'email_text_content' => 'Dear ##USERNAME##,

Your order has been mutually cancelled.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order has been mutually cancelled.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '44',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:13:49',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Dispute Open Notification',
			'description' => 'Notification mail when dispute is opened.',
			'subject' => '##USER_TYPE## has opened a dispute for your order',
			'email_text_content' => 'Dear ##USERNAME##

##OTHER_USER## has made a dispute on your order#: ##ORDERNO## and sent the following dispute message

##MESSAGE##

You need to reply within ##REPLY_DAYS## to avoid making decision in favor of ##USER_TYPE##.

Please click the following link to reply:

##REPLY_LINK##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## has made a dispute on your order#: ##ORDERNO## and sent the following dispute message

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

You need to reply within ##REPLY_DAYS## to avoid making decision in favor of ##USER_TYPE##.

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  Please click the following link to reply:

##REPLY_LINK##

</p></td>

                </tr>    

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME, USER_TYPE, REPLY_DAYS'
		),
		array(
			'id' => '45',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:14:49',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Redeliver accept notification',
			'description' => 'Internal message sent when rework has been accepted by the seller.',
			'subject' => 'Redeliver request accepted by ##OTHER_USER##',
			'email_text_content' => 'Dear ##USERNAME##,

##OTHER_USER## accepted your request.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## accepted your request.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '46',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:15:41',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Redeliver reject notification',
			'description' => 'Internal message for rejected rework.',
			'subject' => 'Redeliver request rejected by ##OTHER_USER##',
			'email_text_content' => 'Dear ##USERNAME##,

##OTHER_USER## has rejected your rework request.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## has rejected your rework request.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

</p></td>

                </tr>  

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '47',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:16:29',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Dispute Conversation Notification',
			'description' => 'Notification mail sent during dispute converstation',
			'subject' => '##OTHER_USER## sent the following dispute conversation',
			'email_text_content' => '##OTHER_USER## sent the following dispute conversation:

##MESSAGE##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## sent the following dispute conversation:

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

 </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME'
		),
		array(
			'id' => '48',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:17:19',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Discussion Threshold for Admin Decision',
			'description' => 'Admin will take decision, after no of conversation to buyer and seller.',
			'subject' => 'Admin will take decision shortly for this dispute.',
			'email_text_content' => 'Admin will take decision shortly for this dispute.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Admin will take decision shortly for this dispute.

</p></td>

                </tr>

 </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'FROM_EMAIL,'
		),
		array(
			'id' => '49',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:20:13',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Dispute Resolved Notification',
			'description' => 'Notification mail to be sent on closing dispute',
			'subject' => 'Dispute has been closed in favor of ##FAVOUR_USER##',
			'email_text_content' => 'Hi ##USERNAME##

Your order dispute has been closed in favor of ##FAVOUR_USER##.

Reason for closed: ##REASON_FOR_CLOSING##

Resolved by: ##RESOLVED_BY##

Dispute Information:

Dispute ID#: ##DISPUTE_ID##

Order ID#: ##ORDER_ID##

Disputer: ##DISPUTER## ##DISPUTER_USER_TYPE##

Reason for dispute: ##REASON##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Hi ##USERNAME##

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Your order dispute has been closed in favor of ##FAVOUR_USER##.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  Reason for closed: ##REASON_FOR_CLOSING##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Resolved by: ##RESOLVED_BY##

</p></td>

                </tr>        

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  Dispute Information: </p>

<p>Dispute ID#: ##DISPUTE_ID##</p>

<p>Order ID#: ##ORDER_ID##</p>

<p>Disputer: ##DISPUTER## ##DISPUTER_USER_TYPE##</p>

<p>Reason for dispute: ##REASON##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, FAVOUR_USER, REASON_FOR_CLOSING, RESOLVED_BY, DISPUTE_ID, ORDER_ID, DISPUTER, DISPUTER_USER_TYPE, REASON'
		),
		array(
			'id' => '50',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-20 05:21:24',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Mutual Cancel Reject Notification',
			'description' => 'Notification message for mutual rejected notification',
			'subject' => '##OTHER_USER## has rejected mutual cancel request',
			'email_text_content' => 'Dear ##USERNAME##,

##OTHER_USER## has rejected your mutual cancel order request.

##MESSAGE##

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

Order#: ##ORDERNO##

',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##SITE_NAME##: Thank you. Please read this information about your order from ##SELLER_NAME##</p>           

            <table border=\"0\" width=\"100%\">

              <tbody>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

Dear ##USERNAME##,

</p></td>

                </tr>  

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##OTHER_USER## has rejected your mutual cancel order request.

</p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

                  ##MESSAGE##

                  </p></td>

                </tr> 

<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

##JOB_ALT_NAME## ordered is: ##JOB_NAME##.Order#: ##ORDERNO##

</p></td>

                </tr> 

</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, JOB_ALT_NAME, ORDERNO, JOB_NAME '
		),
		array(
			'id' => '51',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-12-06 08:18:56',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Launch mail',
			'description' => 'we will send this mail to inform user that the site launched.',
			'subject' => ' ##SITE_NAME## Launched',
			'email_text_content' => 'Dear Subscriber,

##SITE_NAME##  Launched

##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...

##INVITE_LINK##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>        

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>     

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  Launched ##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>                

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,'
		),
		array(
			'id' => '53',
			'created' => '2013-10-23 18:50:37',
			'modified' => '2013-11-20 05:22:55',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Forgot Password',
			'description' => 'we will send this mail, when user submit the forgot password form.',
			'subject' => 'Forgot password request failed',
			'email_text_content' => 'Hi there, 

You (or someone else) entered this email address when trying to change the password of an ##user_email## account. 

However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account. 

If you are not an ##SITE_NAME## customer, please ignore this email. 

If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##. 

Thanks, 

##SITE_NAME## 

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>        

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>  

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Hi there, You (or someone else) entered this email address when trying to change the password of an ##user_email## account. However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account. If you are not an ##SITE_NAME## customer, please ignore this email. If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##. Thanks, ##SITE_NAME## ##SITE_URL##</p></td>

                </tr>	         

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL'
		),
		array(
			'id' => '54',
			'created' => '2013-10-23 18:51:33',
			'modified' => '2013-11-20 05:23:57',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Social User',
			'description' => 'we will send this mail, when user submit the forgot password form and the user users social network websites like twitter, facebook to register.',
			'subject' => 'Forgot password request failed',
			'email_text_content' => 'Hi ##USERNAME##, Your forgot password request was failed because you have registered via ##OTHER_SITE## site. Thanks, ##SITE_NAME## ##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>        

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>  

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Hi ##USERNAME##, Your forgot password request was failed because you have registered via ##OTHER_SITE## site. Thanks, ##SITE_NAME## ##SITE_URL##</p></td>

                </tr>	         

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL,OTHER_SITE'
		),
		array(
			'id' => '55',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Password changed',
			'description' => 'we will send this mail, when user changed his password.',
			'subject' => 'Password changed',
			'email_text_content' => 'Dear ##USERNAME##, 

Successfully you have changed your password at ##SITE_NAME##. If you did not request this action , please contact us ##SUPPORT_EMAIL## 

Thanks, 

##SITE_NAME## 

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Successfully you have changed your password at ##SITE_NAME##. If you did not request this action , please contact us ##SUPPORT_EMAIL## </p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, RESET_URL, SITE_NAME, SITE_URL'
		),
		array(
			'id' => '52',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-12-06 08:19:16',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Private Beta mail',
			'description' => 'we will send this mail to inform user that the site move to Private Beta.',
			'subject' => '##SITE_NAME## moved to Private Beta',
			'email_text_content' => 'Dear Subscriber,

##SITE_NAME##  moved to Private Beta, Click the below link to join us...

##INVITE_LINK##

Invite Code: ##INVITE_CODE##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>        

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>  

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  moved to Private Beta, Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>

	<tr>                  

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Invite Code: ##INVITE_CODE##</p></td>

                </tr>              

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,'
		),
		array(
			'id' => '56',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-11-19 14:45:58',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite User',
			'description' => 'we will send this mail to invite user for private beta.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear Subscriber,

##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...

##INVITE_LINK##

Invite Code: ##INVITE_CODE##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>            

            <table border=\"0\" width=\"100%\">

              <tbody>	  

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>

		<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Invite Code: ##INVITE_CODE##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,'
		),
		array(
            'id' => '57',
            'created' => '2013-11-19 14:34:18',
            'modified' => '2013-11-19 14:34:18',
            'from' => '##FROM_EMAIL##',
            'reply_to' => '##REPLY_TO_EMAIL##',
            'name' => 'Accepted order notification online',
            'description' => 'Internal message will be sent to the buyer, when the ordered job was accepted by the seller.',
            'subject' => 'Your order has been accepted',
            'email_text_content' => 'Dear ##USERNAME##,

Your order has been accepted. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.

##SELLER_CONTACT##

##PRINT##

Print option will be available for the above code in Shopping -> Track order page.',
            'email_html_content' => '<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
<div style="margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;">
  <table cellspacing="0" cellpadding="0" width="720px">
    <tbody>
      <tr>
        <td align="center"><p style="text-align: center; font-size: 11px; color: #929292; margin: 3px;">Be sure to add <a style="color: #30BCEF;" title="Add ##FROM_EMAIL## to your whitelist" href="mailto:##FROM_EMAIL##" target="_blank">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style="border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 ); 

 min-height: 70px;">
<table cellspacing="0" cellpadding="0" width="700">
<tbody>
<tr>
<td  valign="top" style="padding:14px 0 0 10px; width: 110px; min-height: 37px;"><a style="color: #0981be;" title="##SITE_NAME##" href="#" target="_blank"></a><a style="color: #0981be;" title="##SITE_NAME##" href="#" target="_blank"><img style="padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;" src="##SITE_URL##/img/logo.png" alt="[Image: ##SITE_NAME##]" /></a></td>
<td width="505" align="center" valign="top" style="padding-left: 15px; width: 250px; padding-top: 16px;"><a style="color: #0981be;" title="##SITE_NAME##" href="#" target="_blank"></a></td>
<td width="21" align="right" valign="top" style="padding-right: 20px; padding-top: 21px;">&nbsp;</td>
</tr>
</tbody>
</table>
</div>
  
  <div style=" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);">
    <table style="background-color: #ffffff;" width="100%">
      <tbody>
        
        <tr>
          <td style="padding: 20px 30px 5px;"><p style="color: #545454; font-size: 18px;">Dear ##USERNAME##</p>           
            <table border="0" width="100%">
              <tbody>
	<tr>
                  <td><p style=" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Your order has been accepted. The ##JOB_ALT_NAME## ordered is: ##JOB_NAME##.</p></td>
                </tr>
                <tr>
                  <td><p style=" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">
##SELLER_CONTACT##</p></td>
                </tr>
<tr>
                  <td><p style=" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> ##PRINT##</p></td>
                </tr>
<tr>
                  <td><p style=" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> Print option will be available for the above code in Shopping -> Track order page.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style="border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;">
              <h4 style=" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;">Thanks,</h4>
              <h5 style=" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">##SITE_NAME## - <a style="color: #30BCEF;" title="##SITE_NAME## - Collective Buying Power" href="##SITE_LINK##" target="_blank">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style="margin-top: 2px; background-color: #f5f5f5;" width="100%">
      <tbody>
        <tr>
          <td><p style=" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">Need help? Have feedback? Feel free to <a style="color: #30BCEF;" title="Contact ##SITE_NAME##" href="##CONTACT_URL##" target="_blank">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing="0" cellpadding="0" width="720px">
    <tbody>
      <tr>
        <td align="center"><p style="font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;">Delivered by <a style="color: #30BCEF;" title="##SITE_NAME##" href="##SITE_LINK##" target="_blank">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
            'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,'
        ) ,
	);

}
