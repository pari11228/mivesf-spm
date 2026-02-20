#!/usr/bin/env python3
import http.server
import socketserver
import os
import webbrowser
from threading import Timer

PORT = 8000
DIRECTORY = "wordpress"

class Handler(http.server.SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=DIRECTORY, **kwargs)

def open_browser():
    webbrowser.open(f'http://localhost:{PORT}')

if __name__ == "__main__":
    os.chdir(DIRECTORY)
    
    with socketserver.TCPServer(("", PORT), Handler) as httpd:
        print(f"Server running at http://localhost:{PORT}")
        print("WordPress files are being served locally")
        print("Note: This is a static server. For full WordPress functionality, you need PHP+MySQL")
        
        # Open browser after 1 second
        Timer(1.0, open_browser).start()
        
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\nServer stopped.")
