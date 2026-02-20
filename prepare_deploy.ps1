<#
PowerShell helper to create a cleaned zip of the repository excluding
installer, backup and sensitive files before uploading to production.

Usage: Run from the repository root in PowerShell:
  .\prepare_deploy.ps1

Output: spm-clean.zip in repository root
#>

$root = Split-Path -Parent $MyInvocation.MyCommand.Definition
$root = Resolve-Path $root
$root = $root.Path
$temp = Join-Path $root 'deploy_temp'
$zip = Join-Path $root 'spm-clean.zip'

if (Test-Path $temp) { Remove-Item $temp -Recurse -Force }
New-Item -ItemType Directory -Path $temp | Out-Null

# Regex for paths/names to exclude (case-insensitive)
$excludeRegex = [regex]::new('(?i)(\\fruit-shop\\|\\.env|\.env$|setup-final\.php|setup-simple\.php|create-fruit-shop\.php|complete-setup\.php|install-woocommerce\.php|import-products\.php|quick-import\.php|reset-password\.php|fruit-shop-setup\.sql|\\.sql$|\\.zip$|\\.bat$|FILES-PACKAGE\.txt|FINAL-INSTALL-STEPS\.txt|QUICK-INSTALL\.txt)', 'IgnoreCase')

Write-Host "Scanning files and copying allowed items to temporary folder..."

# Get file list first and exclude anything under the temp directory to avoid recursion
$items = Get-ChildItem -Recurse -File | Where-Object { $_.FullName -notmatch '\\deploy_temp\\' -and $_.FullName -notmatch 'spm-clean\.zip$' }

foreach ($it in $items) {
    $full = $it.FullName
    if ($excludeRegex.IsMatch($full)) {
        Write-Host "Excluding: $full" -ForegroundColor DarkYellow
    } else {
        $rel = $full.Substring($root.Length).TrimStart('\','/')
        $dest = Join-Path $temp $rel
        $destDir = Split-Path $dest -Parent
        if (!(Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }
        Copy-Item -Path $full -Destination $dest -Force
    }
}

Write-Host "Creating zip: $zip"
if (Test-Path $zip) { Remove-Item $zip -Force }

try {
    Add-Type -AssemblyName System.IO.Compression.FileSystem
    [System.IO.Compression.ZipFile]::CreateFromDirectory($temp, $zip)
    Write-Host "Zip created successfully: $zip"
} catch {
    Write-Host "Error creating zip: $_" -ForegroundColor Red
    exit 1
}

Remove-Item $temp -Recurse -Force
Write-Host "Done. Created: $zip"
