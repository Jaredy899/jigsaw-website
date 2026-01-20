# Simple Dockerfile to serve the pre-built Jigsaw static site
FROM nginx:alpine

# Copy built site to nginx
COPY build_production/ /usr/share/nginx/html/

# Copy custom nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]