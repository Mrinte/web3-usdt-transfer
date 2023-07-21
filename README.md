# Web3-USDT-Transfer
[![PHP](https://github.com/web3p/web3.php/actions/workflows/php.yml/badge.svg)](https://github.com/web3p/web3.php/actions/workflows/php.yml)
[![Build Status](https://travis-ci.org/web3p/web3.php.svg?branch=master)](https://travis-ci.org/web3p/web3.php)
[![codecov](https://codecov.io/gh/web3p/web3.php/branch/master/graph/badge.svg)](https://codecov.io/gh/web3p/web3.php)
[![Join the chat at https://gitter.im/web3-php/web3.php](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg)](https://gitter.im/web3-php/web3.php)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/web3p/web3.php/blob/master/LICENSE)

本插件用于币安智能链（BNB Chain）的USDT插件转账，其它代币可自行修改ABI和网络URL、合约ABI进行使用；

# 作者：Mrinte <617893305@qq.com>

# 安装引用

设置 minimum stability 为 dev
```
"minimum-stability": "dev"
```

然后执行安装：
```
composer require mrinte/Web3-USDT-Transfer
```

或者在 composer.json 中的 require 内加如下代码，

```
"mrinte/Web3-USDT-Transfer": "dev-master"
```
# PHP 扩展

需要安装PHP的 gmp 扩展，是否需要安装其它扩展可根据情况安装；

# 使用方法

### 转账
```php
use MrInte\Web3USDTTransfer;

// 这是向安智能链（BNB Chain) 代币BSC的USDT合约地址；
$data['contractAddress']  = '0x55d398326f99059fF775485246999027B3197955';

$data['contractABI']      = 'ABI的JSON字条串，内容太长，不便显示，下面补充！';
$data['PrivateKey']       = '转出账号的私钥';
$data['fromAccount']      = '转出账号';
$data['ToAddr']           = '接收账号';
$data['payAmount']        = 0.01;    // 转账数额（数值）
$data['ChainUrl']         = 'https://bsc-dataseed1.binance.org';    // 网络 RPC URL
$data['chainId']          = 56;         // 链 ID （数值）

$USDTTransfer = new Web3USDTTransfer($data);    // 返回交易哈希址地（USDTTransfer）字符串
```

### 通过交易哈希获取交易信息
```php
use MrInte\Web3USDTTransfer;

// 交易详情对象和数组；
$ChainUrl        = 'https://bsc-dataseed1.binance.org';    // 网络 RPC URL
$TransactionHash = '交易哈希字条串';

$Transaction = $Web3USDTTransfer->getTransferStatus($ChainUrl,$TransactionHash);;    // 返回交易详情对象和数组
```

### 合约ABI（contractABI）
可以通过 $data["contractAddress"] 的值在 [https://bscscan.com/](https://bscscan.com/address/0x55d398326f99059ff775485246999027b3197955#code) 上查看ABI；

```json
[
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
]
```
