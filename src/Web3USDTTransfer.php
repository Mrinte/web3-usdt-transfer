<?php

/**
 * 本插件用于币安智能链（BNB Chain）的USDT插件转账，其它代币可自行修改ABI和网络URL、合约ABI进行使用；
 * (c) MrInte <617893305@qq.com>
 * @author MrInte <617893305@qq.com>
 * @license MIT
 */

namespace MrInte;

use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Contract;
use Web3\Utils;
use Web3p\EthereumTx\Transaction;
use EthTool\Callback;


class Web3USDTTransfer{
    
    protected $chainId;
    protected $ChainUrl;
    protected $contractABI;
    protected $contractAddress;

    /**
     * 本程序默认使用币安智能链（BNB Chain）的代币 USDT 转账，其它代币请带入ABI、链ID、RPC URL、合约地址等；
     * 作者：Mrinte
     * 邮箱：617893305@qq.com
     */
    public function __construct(){
		$this->chain_id         = 56;
		$this->ChainUrl         = 'https://bsc-dataseed1.binance.org';
		$this->contractAddress  = '0x55d398326f99059fF775485246999027B3197955';
        $this->contractABI      = '[
            {"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},
            {"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},
            {"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"previousOwner","type":"address"},{"indexed":true,"internalType":"address","name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"},
            {"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},
            {"constant":true,"inputs":[],"name":"_decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":true,"inputs":[],"name":"_name","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":true,"inputs":[],"name":"_symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":true,"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":true,"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"burn","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":true,"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":true,"inputs":[],"name":"getOwner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":false,"inputs":[{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"mint","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":true,"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":true,"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[],"name":"renounceOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":true,"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"sender","type":"address"},{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},
            {"constant":false,"inputs":[{"internalType":"address","name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"}
        ]';
    }
    
    public function USDTTransfer($Data){
		$contractAddress   = (isset($Data['contractAddress']) && trim($Data['contractAddress'] != '') ? trim($Data['contractAddress']) : $this->contractAddress);
		$ChainUrl   = (isset($Data['ChainUrl'])     && trim($Data['ChainUrl'])      != '' ? trim($Data['ChainUrl'])     : $this->ChainUrl);
		$contractABI= (isset($Data['contractABI'])  && trim($Data['contractABI'])   != '' ? trim($Data['contractABI'])  : $this->contractABI);
		$chainId    = (isset($Data['chainId'])      && intval($Data['chainId'])     > 0   ? intval($Data['chainId'])    : $this->chainId);
		
		$PrivateKey = trim($Data['PrivateKey']);
		$fromAccount= trim($Data['fromAccount']);
		$ToAddr		= trim($Data['ToAddr']);
		$payAmount  = round($Data['payAmount'],2);
		
		$Web3       = new Web3($ChainUrl);
		$contract   = new Contract($ChainUrl, $contractABI);
		$Callback   = new Callback();
		$eth        = $contract->eth;
		
		// 验证地址
		$contractAddress    = $Web3->utils->toChecksumAddress($contractAddress);
		$fromAccount        = $Web3->utils->toChecksumAddress($fromAccount);
		$ToAddr		        = $Web3->utils->toChecksumAddress($ToAddr);
		
		// 金额转 ether
		$payAmountHex = $Web3->utils->toHex(strval($Web3->utils->toWei(strval($payAmount), 'ether')),true);
		
		
		//余额
		$contract->at($contractAddress)->call('balanceOf', $fromAccount, ['from' => $fromAccount], $Callback);
		$balance = floatval($Callback->result[0]->toString()) / 1000000000000000000;

		// 订单序号
		$eth->getTransactionCount($fromAccount,$Callback);
		$nonce_int  = strval($Callback->result->value);
		$nonce      = $Web3->utils->toHex(strval($Callback->result->value),true);
		$nonce      = ($nonce == '0x' ? $nonce.'0' : $nonce);

		// 合约数据
		$rawTransactionData = '0x' . $contract->at($contractAddress)->getData('transfer', $ToAddr, $payAmountHex);
		
		$transactionParams = [
		    //'nonce_int' => $nonce_int,
		    'nonce'     => $nonce,
		    'from'      => $fromAccount,
		    'to'        => $contractAddress,
		    'gas'       => $Web3->utils->toHex(strval(8000000),true),
		    'value'     => '0x0',
		    'data'      => $rawTransactionData,
		];

		// 转账数据 gas
		$eth->estimateGas($transactionParams,$Callback);
		$transactionParams['gas']       = $Web3->utils->toHex(strval($Callback->result->value),true);
		
		// 转账数据 gasPrice
		$eth->gasPrice($Callback);
		$transactionParams['gasPrice']       = $Web3->utils->toHex(strval($Callback->result->value),true);

		// 链ID
		$transactionParams['chainId'] = 56;
		
		// 私钥签名
		$tx = new Transaction($transactionParams);

		$signedTx = '0x' . $tx->sign($PrivateKey);
		$eth->sendRawTransaction($signedTx,$Callback);
		
		return $Callback->result;
    }
    
    public function getTransferStatus($paramChainUrl,$Transaction){
		$ChainUrl   = (trim($paramChainUrl) != '' ? trim($paramChainUrl) : $this->ChainUrl);
		$Web3       = new Web3($ChainUrl);
		$Callback   = new Callback();

		$Web3->eth->getTransactionReceipt($Transaction,$Callback);
		
		$result['Object'] = $Callback->result;
		
		$result["Array"]                        = json_decode(json_encode($Callback->result),true);
		$result["Array"]['type']                = hexdec($result['Array']['type']);
		$result["Array"]['status']              = hexdec($result['Array']['status']);
		$result["Array"]['cumulativeGasUsed']   = hexdec($result['Array']['cumulativeGasUsed']);
		$result["Array"]['gasUsed']             = hexdec($result['Array']['gasUsed']);
		$result["Array"]['blockNumber']         = hexdec($result['Array']['blockNumber']);
		$result["Array"]['transactionIndex']    = hexdec($result['Array']['transactionIndex']);
		$result["Array"]['effectiveGasPrice']   = hexdec($result['Array']['effectiveGasPrice']);
		
		return $result;
    }
    
}