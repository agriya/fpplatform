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
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
}
class ConstAttachment
{
    const UserAvatar = 2;
    const Job = 1;
}
class ConstFriendRequestStatus
{
    const Pending = 1;
    const Approved = 2;
    const Reject = 3;
}
class ConstMessageFolder
{
    const Inbox = 1;
    const SentMail = 2;
    const Drafts = 3;
    const Spam = 4;
    const Trash = 5;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
class ConstPaymentGateways
{
   const Wallet = 2;
	const SudoPay = 3;     
    const Active = 10;	
    const Project = 8;  
	const ManualPay = 5;  
    const Testmode = 7;
    const Masspay = 6;
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstPaymentGatewayFilterOptions
{
    const Active = 1;
    const Inactive = 2;
    const TestMode = 3;
    const LiveMode = 4;
}
class ConstPaymentGatewayMoreActions
{
    const Activate = 1;
    const Deactivate = 2;
    const MakeTestMode = 3;
    const MakeLiveMode = 4;
    const Delete = 5;
}
class ConstSettingValue
{
	const JobPrice = 160;
	const JobCommissionAmount = 169;
	const JobCommissionType = 213;
}
class ConstContatctType
{
    const ConflictWithSellerOrBuyer = 3;
    const Other = 7;
}
class ConstServiceLocation{
	const BuyerToSeller = 1;
	const SellerToBuyer = 2;
}
class ConstJobType{
	const Online = 1;
	const Offline = 2;
}
class ConstDisputeStatus{
	const Open = 1;
	const UnderDiscussion = 2;
	const WaitingForAdministratorDecision = 3;
	const Closed = 4;
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
	const Approved = 6;
    const Disapproved = 7;
    const Featured = 8;
    const Notfeatured = 9;
	const Satisfy = 10;
    const Unsatisfy = 11;
	const Feature = 12;
    const Unfeature = 13;
    const WaitingforAcceptance = 13;
    const InProgress = 14;
    const WaitingforReview = 15;
    const Completed = 16;
    const Cancelled = 17;
    const Rejected = 18;
    const PaymentCleared = 19;
    const Suspend = 20;
    const Unsuspend = 21;
    const Twitter = 22;
    const Facebook = 23;
    const IsReplied = 23;
    const Flagged = 24;
    const Unflagged = 25;
    const DeActivateUser = 26;
    const ActivateUser = 27;
    const Checked = 28;
    const Unchecked = 29;
    const NotifiedInactiveUsers = 30;
    const Expired = 31;
    const InProgressOvertime = 32;
    const CancelledDueToOvertime = 33;
    const CancelledByAdmin = 34;
    const CompletedAndClosedByAdmin = 35;
    const Trash = 36;
    const UserFlagged = 37;
	const Normal = 38;
	const Gmail = 39;
	const Yahoo = 40;
	const Online = 41;
	const Offline = 42;
    const LinkedIn = 43;
    const GooglePlus = 44;
	const Publish = 46;
    const Unpublish = 47;
	const Prelaunch = 49;
	const PrivateBeta = 50;
	const PrelaunchSubscribed = 51;
	const PrivateBetaSubscribed = 52;
	const Subscribed = 54;
	const Unsubscribed = 55;
    const AffiliateUser = 56;
	const Site = 57;
}
class ConstTransactionTypes
{
    const AddedToWallet = 1;
    const BuyJob = 2;
    const PaidAmountToUser = 3;
    //const PaidDealAmountToUser = 3;
    const UserCashWithdrawalAmount = 4;
    const RefundForRejectedJobs = 5;
    const RefundForCancelledJobs = 6;
    const AcceptCashWithdrawRequest = 7;
	const AmountTransferredForSeller = 8;
	const SellerAmountCleared = 9;
	const SellerDeductedForRejectedJob = 10;
	const SellerDeductedForCancelledJob = 11;
	const BuyerOrderStatusToInProgressOvertime = 12;
	const BuyerCancelledDueToOvertime = 13;
	const CancelledByAdminRefundToBuyer = 14;
    const RefundForExpiredJobs = 15;
	const SellerDeductedForExpiredJob = 16;
	const CancelledByAdminDeductFromSeller = 17;
	const UserWithdrawalRequest = 18;
    const AdminApprovedWithdrawalRequest = 19;
    const AdminRejecetedWithdrawalRequest = 20;
    const FailedWithdrawalRequest = 21;
    const AmountRefundedForRejectedWithdrawalRequest = 23;
    const AmountApprovedForUserCashWithdrawalRequest = 24;
    const FailedWithdrawalRequestRefundToUser = 25;
	const SendMoneyToUser  = 26;
	const AffliateUserWithdrawalRequest = 28;
	const AffliateAdminApprovedWithdrawalRequest = 29;
	const AffliateAdminRejecetedWithdrawalRequest = 30;
	const AffliateFailedWithdrawalRequest = 31;
	const AffliateAmountRefundedForRejectedWithdrawalRequest = 33;
	const AffliateAmountApprovedForUserCashWithdrawalRequest = 32;
	const AffliateFailedWithdrawalRequestRefundToUser = 34;
	const AffliateAddFundToAffiliate = 35;
	const AffliateAcceptCashWithdrawRequest = 36;
	const SignupFee = 37;
	const CashWithdrawalRequestPaid = 38;
	const CashWithdrawalRequest = 39;
	const CashWithdrawalRequestApproved = 40;
	const CashWithdrawalRequestRejected = 41;
}
class constContentType
{
    const Page = 1;
}
class ConstJobOrderStatus
{
    const WaitingforAcceptance = 1;
    const InProgress = 2;
    const WaitingforReview = 3;
    const Completed = 4;
    const Cancelled = 5;
    const Rejected = 6;
    const PaymentCleared = 7;
    const Expired = 8;
    const InProgressOvertime = 9;
    const CancelledDueToOvertime = 10;
    const CancelledByAdmin = 11;
    const CompletedAndClosedByAdmin = 12;
    const PaymentPending = 13;
	const Redeliver = 14;
	const MutualCancelled = 15;
	//-- Dummy classes for categories various actions in activities --//
	// 'Not' order status and not in table. It is used for differentiating sender notification mails. Used in 'activities'
	const RedeliverRequestCancel = 37;
	const MutualCancelRejected = 38;
	const AdminDisputeConversation = 39;
	const DisputeAdminAction = 40;
	const WorkReviewed = 41;
	const WorkDelivered = 42;
	const DisputeClosedTemp = 43; // temp; for not to show the second dispute mail
	const DisputeClosed = 44;
	const DisputeConversation = 45;
	const DisputeOpened = 46;
	const RedeliverRejected = 47;
	const RedeliverRequest = 48;
	const MutualCancelRequest = 49;
	const SenderNotification = 50;
}
class ConstCommsisionType
{
    const Amount = 'amount';
    const Percentage = 'percentage';
}
class ConstJobAlternateName
{
	const FirstLeterCaps = 1;
	const Plural = 2;
	const Singular = 3;
}
class ConstRequestAlternateName
{
	const FirstLeterCaps = 1;
	const Plural = 2;
	const Singular = 3;
}
class ConstJobUserType
{
	const Buyer = 1;
	const Seller = 2;
}
class ConstPaymentGatewayFlow
{
	const BuyerSiteSeller = 'Buyer -> Site -> Seller';
	const BuyerSellerSite = 'Buyer -> Seller -> Site';
}
$config['gig']['payment_gateway_flow_id'] = 'Buyer -> Site -> Seller';
class ConstPaymentGatewayFee
{	
	const Seller = 'Seller';
	const Site = 'Site';
	const SiteAndSeller = 'Site and Seller';
}
class ConstViewType{
	const NormalView = 1;
	const EmbedView = 2;
}
class ConstSiteState
{
    const Prelaunch = 1;
	const PrivateBeta = 2;
	const Launch = 3;
}
class ConstUserAvatarSource
{
    const Attachment = 1;
	const Facebook = 2;
	const Twitter = 3;
	const Google = 4;
	const Linkedin = 5;
	const GooglePlus = 6;
}
class ConstPaymentGatewaysName
{
    const SudoPay = 'SudoPay';
}
class ConstPaymentType
{
    const JobOrder = 1;
    const Wallet = 2;
}
class ConstPluginSettingCategories
{    
    const Jobs = 4;
    const Requests = 17;
    const Disputes = 19;
    const Wallet = 18;
    const Withdrawals = 12;
    const Affiliates = 20;    
    const Regional = 52;
    const HighPerformance = 25;	
	const Developments = 22;
	const SocialMarketing = 51;	
}

?>
