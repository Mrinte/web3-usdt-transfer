# Web3-USDT-Transfer
[![PHP](https://github.com/web3p/web3.php/actions/workflows/php.yml/badge.svg)](https://github.com/web3p/web3.php/actions/workflows/php.yml)
[![Build Status](https://travis-ci.org/web3p/web3.php.svg?branch=master)](https://travis-ci.org/web3p/web3.php)
[![codecov](https://codecov.io/gh/web3p/web3.php/branch/master/graph/badge.svg)](https://codecov.io/gh/web3p/web3.php)
[![Join the chat at https://gitter.im/web3-php/web3.php](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg)](https://gitter.im/web3-php/web3.php)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/web3p/web3.php/blob/master/LICENSE)

本插件用于币安智能链（BNB Chain）的USDT插件转账，其它代币可自行修改ABI和网络URL、合约ABI进行使用；


# Install

Set minimum stability to dev
```
"minimum-stability": "dev"
```

Then
```
composer require mrinte/web3.php dev-master
```

Or you can add this line in composer.json

```
"mrinte/web3.php": "dev-master"
```


# Usage

### New instance
```php
use MrInte\Web3USDTTransfer;

$data['contractAddress']  = '0x55d398326f99059fF775485246999027B3197955';    // 这是向安智能链（BNB Chain) 代币BSC的USDT合约地址；
$data['contractABI']      = 'ABI的JSON字条串，可以通过 $data['contractAddress'] 的值在 https://bscscan.com/ 上查看ABI；内容太长，不便显示，下面补充！';
$data['PrivateKey']       = '转出账号的私钥';
$data['fromAccount']      = '转出账号';
$data['ToAddr']           = '接收账号';
$data['payAmount']        = '转账数额';
$data['ChainUrl']         = 'https://bsc-dataseed1.binance.org';    // 网络 RPC URL
$data['chainId']          = '56';    // 链 ID
$web3 = new Web3('http://localhost:8545');
```

### Using provider
```php
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('http://localhost:8545')));

// timeout
$web3 = new Web3(new HttpProvider(new HttpRequestManager('http://localhost:8545', 0.1)));
```
