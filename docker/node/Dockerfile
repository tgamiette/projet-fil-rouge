# pull official base image
FROM node:13.12.0-alpine

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install app dependencies
COPY ./app/front/package.json ./
RUN npm install --silent
RUN npm install react-scripts -g --silent

## add app
COPY /app/front/ ./

# start app
CMD ["npm", "start"]
