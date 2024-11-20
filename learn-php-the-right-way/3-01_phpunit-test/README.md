## Test

### Testing Types

- Accessibility Testing 可用性测试
- Acceptance Testing 验收测试
- End-to-End Testing 端到端测试
- Functional Testing 功能测试
- Integration Testing 集成测试
- Load Testing 负载测试
- Unit Testing 单元测试
- Stress Testing 压力测试
- Regression Testing 回归测试
- Smoke Testing 冒烟测试
- And more ...

#### Unit Testing

> Tests small piece of code and mocks/fakes any needed dependencies or database connections

#### Integration Testing

> Tests multiple modules or units together. Dependencies can be resolved and can use database connections

#### TDD and BDD

- __TDD__: Test Driven Development
- __BDD__ Behavior Driven Development

They are both __Tests First, Code After__

### PHPUnit

[Documentation](https://phpunit.de/index.html)

```shell 
composer require --dev phpunit/phpunit

# write unit tests, and execute the command below:
./vendor/bin/phpunit
```
