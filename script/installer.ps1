
$ErrorActionPreference = "silentlycontinue" 

Function Test-CommandNotExists {
	Param ($Command)
	$OldPreference = $ErrorActionPreference
	$ErrorActionPreference = 'stop'
	Try {
		If (Get-Command $Command) {
			Return $False
		}
	}
	Catch {		
		Return $True
	}
	Finally {
		$ErrorActionPreference = $OldPreference
	}
} 

If (Test-CommandNotExists scoop) {
	Write-Host "Get scoop..."
	Set-ExecutionPolicy RemoteSigned -scope CurrentUser
	Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')	
}

If (Test-CommandNotExists php) {
	Write-Host "Install php..."
	scoop bucket add php
	scoop install "php/php7.0"
}

If (Test-CommandNotExists composer) {
	Write-Host "Install composer..."
	scoop install composer
}

If (Test-CommandNotExists vtiger) {
	Write-Host "Install vtiger tool..."
	scoop bucket add javanile https://github.com/javanile/scoop-bucket.git
	scoop update
	scoop install javanile/vtiger
}

Write-Host "`r`n>>> Your vtiger tool is ready.`r`n"
