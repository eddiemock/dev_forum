#!/bin/bash

# Echo a message to indicate where the startup script is running
echo "Running the startup script to start Nginx..."

# Start Nginx in the foreground
# This command might vary based on your specific setup or Docker container
nginx -g 'daemon off;'

# Alternatively, if you need to use a custom nginx configuration file
# nginx -c /path/to/your/custom/nginx.conf -g 'daemon off;'

# You can add other commands here as needed

echo "Nginx has been started."
