@echo off
REM Laravel PDF Generator - Windows Deployment Launcher
REM This batch file launches the PowerShell deployment script

echo.
echo ==================================================
echo    Laravel PDF Generator - Windows Deployment
echo ==================================================
echo.

REM Check if PowerShell is available
powershell -Command "Get-Host" >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PowerShell is not available on this system.
    echo Please install PowerShell or use the bash script instead.
    echo.
    pause
    exit /b 1
)

REM Check if the PowerShell script exists
if not exist "deploy-windows.ps1" (
    echo ERROR: deploy-windows.ps1 not found in the current directory.
    echo Please ensure you're running this from the project root directory.
    echo.
    pause
    exit /b 1
)

echo Starting PowerShell deployment script...
echo.
echo Note: You may be prompted to allow script execution.
echo If prompted, type 'Y' and press Enter.
echo.

REM Launch PowerShell script
powershell -ExecutionPolicy Bypass -File "deploy-windows.ps1"

REM Check if the script completed successfully
if %errorlevel% equ 0 (
    echo.
    echo ==================================================
    echo    Deployment completed successfully!
    echo ==================================================
    echo.
    echo Your Laravel application should now be running at:
    echo http://localhost:8000
    echo.
    echo Press any key to exit...
    pause >nul
) else (
    echo.
    echo ==================================================
    echo    Deployment failed!
    echo ==================================================
    echo.
    echo Please check the error messages above and try again.
    echo.
    echo Press any key to exit...
    pause >nul
    exit /b 1
)
