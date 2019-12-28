FROM golang:alpine

RUN mkdir /app

WORKDIR /app

COPY ./category-microservice /app

EXPOSE 8080

HEALTHCHECK --interval=60s --timeout=10s CMD curl --fail http://localhost:8080/api/v1/health-check || exit 1

CMD ./run-local.sh
